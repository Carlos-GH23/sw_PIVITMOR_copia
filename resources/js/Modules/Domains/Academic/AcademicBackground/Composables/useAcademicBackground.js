import { useForm, router } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";

export const useAcademicBackground = (routeName, academicBackground = {}) => {
    const academicData = academicBackground?.data ?? academicBackground;
    const form = useForm({
        _method: academicData.id ? "patch" : "post",
        academic_title: academicData.academic_title ?? null,
        institution_name: academicData.institution_name ?? null,
        academic_degree_id: academicData.academic_degree_id ?? null,
        knowledge_area_id: academicData.knowledge_area_id ?? null,
        country_id: academicData.country_id ?? null,
        degree_obtained_at: academicData.degree_obtained_at ?? null,
        certificate_number: academicData.certificate_number ?? null,
        files: academicData.files ?? [],
    });

    const saveForm = () => {
        form.post(route(`${routeName}store`));
    };

    const updateForm = () => {
        form.post(route(`${routeName}update`, { academicBackground: academicData.id }));
    };


    provide("form", form);

    return {
        form,
        processing: computed(() => form.processing),
        saveForm,
        updateForm,
    };
};

export const deleteAcademicBackground = async (academicBackgroundId) => {
    const result = await messageConfirm();
    if (!result.isConfirmed) return;

    router.delete(route('academics.academicBackgrounds.destroy', academicBackgroundId));
}