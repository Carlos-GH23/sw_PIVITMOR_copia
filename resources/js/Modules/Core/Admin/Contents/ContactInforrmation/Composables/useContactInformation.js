import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { provide, watch } from "vue";

export const useContactInformation = (props, mapApi = {}) => {
    const contactInfo = props.contactInformation?.data || {};

    const form = useForm({
        _method: "patch",
        email: contactInfo.email || "",
        address: contactInfo.address || "",
        latitude: contactInfo.latitude ?? null,
        longitude: contactInfo.longitude ?? null,
        opening_time: contactInfo.opening_time || "",
        closing_time: contactInfo.closing_time || "",
        phones: contactInfo.phone_numbers || [],
    });

    let debounceTimeout = null;
    let initialized = false;
    if (mapApi && mapApi.searchAddress && mapApi.setMarker && mapApi.coordinates && mapApi.DEFAULT_COORDS) {
        watch(
            () => form.address,
            (newAddress) => {
                if (!initialized) {
                    initialized = true;
                    return;
                }
                if (debounceTimeout) clearTimeout(debounceTimeout);
                if (newAddress && newAddress.length > 5) {
                    debounceTimeout = setTimeout(async () => {
                        const found = await mapApi.searchAddress(newAddress);
                        if (found && mapApi.coordinates.value.lat && mapApi.coordinates.value.lng) {
                            mapApi.setMarker(mapApi.coordinates.value.lat, mapApi.coordinates.value.lng, newAddress);
                            form.latitude = mapApi.coordinates.value.lat;
                            form.longitude = mapApi.coordinates.value.lng;
                        } else if (!found) {
                            mapApi.setMarker(mapApi.DEFAULT_COORDS.lat, mapApi.DEFAULT_COORDS.lng, 'No se encontró la dirección');
                            form.latitude = null;
                            form.longitude = null;
                        }
                    }, 600);
                }
            }
        );
    }

    const updateForm = () => {
        form.post(route(`${props.routeName}update`), {
            onError: () => {
                error422();
            },
            onSuccess: () => {
                syncForm();
            },
        });
    };

    const syncForm = () => {
        const updatedData = props.contactInformation?.data;
        if (!updatedData) return;

        if (updatedData.phone_numbers) {
            const currentPhones = JSON.stringify(form.phones);
            const newPhones = JSON.stringify(updatedData.phone_numbers);
            if (currentPhones !== newPhones) {
                form.phones = [...updatedData.phone_numbers];
            }
        }
        form.email = updatedData.email || "";
        form.address = updatedData.address || "";
        form.latitude = updatedData.latitude ?? null;
        form.longitude = updatedData.longitude ?? null;
        form.opening_time = updatedData.opening_time || "";
        form.closing_time = updatedData.closing_time || "";
    };

    provide("form", form);

    return {
        form,
        processing: form.processing,
        updateForm,
    };
};
