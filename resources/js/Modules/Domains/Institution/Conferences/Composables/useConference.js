import { useLoading } from "@/Hooks/useLoading";
import { router, useForm } from "@inertiajs/vue3";
import { provide } from "vue";
import { error422, messageConfirm } from "@/Hooks/useErrorsForm";



export const useConference = (props) => {
    const { isLoading, setLoading } = useLoading();
    const { conference } = props;
    
    // Los datos están en conference.data
    const conferenceData = conference?.data || conference;

    const form = useForm({
        _method: conferenceData?.id ? "patch" : "post",

        title: conferenceData?.title ?? null,
        description: conferenceData?.description ?? null,
        speaker_bio: conferenceData?.speaker_bio ?? null,
        start_date: conferenceData?.start_date ?? null,
        end_date: conferenceData?.end_date ?? null,
        language_id: conferenceData?.language_id ?? null,
        technical_requirements: conferenceData?.technical_requirements ?? null,
        audience_types: conferenceData?.audience_types?.map(a => a.id) ?? [],
        modality: conferenceData?.modality ?? null,
        department_id: conferenceData?.department_id ?? null,
        academics: conferenceData?.academics?.map(a => a.id) ?? [],
        oecd_sectors: conferenceData?.oecd_sectors?.map(s => s.id) ?? [],
        economic_sectors: conferenceData?.economic_sectors?.map(s => s.id) ?? [],
        keywords: conferenceData?.keywords ?? [],
        files: conferenceData?.files ?? [],
        conference_status_id: conferenceData?.conference_status_id ?? 1,
    });



  const storeForm = (isDraft = true) => {
        if (!isDraft) form.conference_status_id = 2;
        form.post(route(`${props.routeName}store`), {
            onError: () => {
                error422();
            },
        });
    };

    const updateForm = (isDraft = true) => {
        if (!isDraft) form.conference_status_id = 2;
        form.post(route(`${props.routeName}update`, conferenceData?.id), {
            onError: () => {
                error422();
            },
        });
    };
    const deleteForm = (conference) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                router.delete(route(`${props.routeName}destroy`, conference.id));
            }
        });
    };


    provide("conferenceForm", form);

    return {
        form,
        isLoading,
        storeForm,
        updateForm,
        deleteForm,
        processing: form.processing,
    };
}

export const enableConference = async (conferenceId) => {
    router.patch(route("conferences.enable", conferenceId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resolve(true);
        },
        onError: () => {
            reject(false);
        },
    });
};