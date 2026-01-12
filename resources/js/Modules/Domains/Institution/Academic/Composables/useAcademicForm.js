import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { router, useForm } from "@inertiajs/vue3";
import { provide, watch } from "vue";

export function useAcademicForm(props) {
    const academic = props.academic?.data || {};

    const form = useForm({
        _method: academic.id ? "patch" : "post",
        first_name: academic.first_name,
        last_name: academic.last_name,
        second_last_name: academic.second_last_name,
        academic_position_id: academic.academic_position?.id ?? null,
        biography: academic.biography,
        knowledge_lines: academic?.knowledge_lines ?? [],
        academic_degree_id: academic.academic_degree?.id ?? null,
        department_id: academic.department?.id ?? null,
        gender: academic.gender ?? null,

        photo: {
            id: academic.photo?.id ?? null,
            path: academic.photo?.path ?? null,
            file: null,
            delete_photo: false,
        },

        contact: {
            id: academic.contact?.id ?? null,
            email: academic.contact?.email,
        },

        sni: {
            has_sni: !!academic.sni_membership,
            number: academic.sni_membership?.number ?? null,
            start_date: academic.sni_membership?.start_date ?? null,
            end_date: academic.sni_membership?.end_date ?? null,
            research_area_id: academic.sni_membership?.research_area_id ?? null,
            sni_level_id: academic.sni_membership?.sni_level_id ?? null,
        },

        profile: {
            has_profile: !!(academic.desirable_profile?.start_date && academic.desirable_profile?.end_date),
            start_date: academic.desirable_profile?.start_date ?? null,
            end_date: academic.desirable_profile?.end_date ?? null,
        },

        oecd_sectors: academic.oecd_sectors?.map((sector) => sector.id) ?? [],
        economic_sectors: academic.economic_sectors?.map((economic) => economic.id) ?? [],
    });

    watch(() => form.profile.has_profile, (value) => {
        if (!value) {
            form.profile.start_date = null;
            form.profile.end_date = null;
        }
    });

    watch(() => form.sni.has_sni, (value) => {
        if (!value) {
            form.sni.number = null;
            form.sni.sni_level_id = null;
            form.sni.research_area_id = null;
            form.sni.start_date = null;
            form.sni.end_date = null;
        }
    });

    const storeForm = () => {
        form.post(route(`${props.routeName}store`),
            {
                onError: () => {
                    error422();
                },
            }
        );
    };

    const updateForm = () => {
        form.post(
            route(`${props.routeName}update`, academic.id),
            {
                onError: () => {
                    error422();
                },
            }
        );
    };

    const deleteForm = (id) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                router.delete(route(`${props.routeName}destroy`, id), {
                    preserveState: false,
                });
            }
        });
    };

    const enable = (id) => {
        router.patch(route(`${props.routeName}enable`, id), {}, {
            preserveScroll: true,
        });
    };

    provide('form', form)
    provide('props', props)
    provide('positions', props.positions)
    provide('sniiAreas', props.sniiAreas)
    provide('sniiLevels', props.sniiLevels)
    provide('departments', props.departments)
    provide("oecdSectors", props.oecdSectors)
    provide("economicSectors", props.economicSectors)
    provide('academicDegrees', props.academicDegrees)
    provide('genders', props.genders)

    return {
        processing: form.processing,
        storeForm,
        updateForm,
        deleteForm,
        enable,
    };
}