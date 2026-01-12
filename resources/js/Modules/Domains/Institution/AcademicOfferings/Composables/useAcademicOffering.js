import { router, useForm } from "@inertiajs/vue3";
import { error422, error500, messageConfirm } from "@/Hooks/useErrorsForm";
import { computed, provide } from "vue";

export const useAcademicOffering = (props) => {
    const academicOffering = props.academicOffering?.data ?? {};

    const form = useForm({
        _method: academicOffering?.id ? "patch" : "post",
        name: academicOffering?.name ?? null,
        description: academicOffering?.description ?? null,
        objective: academicOffering?.objective ?? null,
        graduate_profile: academicOffering?.graduate_profile ?? null,
        website: academicOffering?.website ?? null,
        semester_cost: academicOffering?.semester_cost ?? null,
        duration_months: academicOffering?.duration_months ?? null,
        revoe: academicOffering?.revoe ?? null,
        keywords: academicOffering?.keywords ?? [],

        educational_level_id: academicOffering?.educational_level?.id ?? null,
        study_mode_id: academicOffering?.study_mode?.id ?? null,
        department_id: academicOffering?.department?.id ?? null,

        has_copaes_accreditation: academicOffering?.copaes_accreditation_program?.copaes_accreditation?.id ? true : false,
        copaes_accreditation_id: academicOffering?.copaes_accreditation_program?.copaes_accreditation?.id ?? null,
        copaes_expiry_date: academicOffering?.copaes_accreditation_program?.expiry_date ?? null,

        has_ciees_accreditation: academicOffering?.ciees_accreditation_program?.ciees_accreditation?.id ? true : false,
        ciees_accreditation_id: academicOffering?.ciees_accreditation_program?.ciees_accreditation?.id ?? null,
        ciees_level: academicOffering?.ciees_accreditation_program?.level ?? null,
        ciees_expiry_date: academicOffering?.ciees_accreditation_program?.expiry_date ?? null,

        has_snp: academicOffering?.postgraduate_detail?.id ? true : false,
        snp_start_date: academicOffering?.postgraduate_detail?.start_date ?? null,
        snp_end_date: academicOffering?.postgraduate_detail?.end_date ?? null,

        fimpes_accreditation_id: academicOffering?.fimpes_accreditation_id ?? null,

        economic_sectors: academicOffering?.economic_sectors?.map((sector) => sector.id) ?? [],
        oecd_sectors: academicOffering?.oecd_sectors?.map((sector) => sector.id) ?? [],

        files: academicOffering?.files ?? []
    });

    const storeForm = () => {
        form.post(route(`academicOfferings.store`), {
            onError: () => error422(),
        });
    };

    const updateForm = () => {
        form.post(route(`academicOfferings.update`, academicOffering?.id), {
            onError: () => error422(),
        });
    };

    const deleteAcademicOffering = async (id) => {
        if (!id) return;

        const result = await messageConfirm();
        if (!result.isConfirmed) return;

        router.delete(route('academicOfferings.destroy', id), {
            onError: (err) => error500(),
        });
    };

    const enableForm = async (id) => {
        router.patch(route("academicOfferings.enable", id), {
            onSuccess: () => {
                resolve(true);
            },
            onError: () => {
                resolve(false);
            }
        });
    };


    provide("form", form);
    provide("educationalLevels", props.educationalLevels);
    provide("studyModes", props.studyModes);
    provide("departments", props.departments);
    provide("oecdSectors", props.oecdSectors);
    provide("economicSectors", props.economicSectors);
    provide("copaesAccreditations", props.copaesAccreditations);
    provide("cieesAccreditations", props.cieesAccreditations);
    provide("fimpesAccreditations", props.fimpesAccreditations);

    return {
        form,
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
        deleteAcademicOffering,
        enableForm,
    }
}