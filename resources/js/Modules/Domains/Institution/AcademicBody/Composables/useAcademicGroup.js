import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { useForm, router } from "@inertiajs/vue3";
import { provide, computed } from "vue";

export const useAcademicGroup = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const academicBody = props.academicBody?.data ?? {};

    const form = useForm({
        _method: props.academicBody ? "patch" : "post",
        name: academicBody?.name ?? null,
        consolidation_degree_id: academicBody?.consolidation_degree?.id ?? null,
        key: academicBody?.key ?? null,
        review: academicBody?.review ?? null,
        department_id: academicBody?.department?.id ?? null,
        academics: academicBody?.academics?.map(academic => academic.id) ?? [],
        research_lines: academicBody?.research_lines?.map(line => line.id) ?? [],
        knowledge_lines: academicBody?.knowledge_lines ?? [],
        files: academicBody?.files ?? [],
        economic_sectors: academicBody?.economic_sectors?.map(economic => economic.id) ?? [],
        oecd_sectors: academicBody?.oecd_sectors?.map(sector => sector.id) ?? [],
    });

    const storeForm = () => {
        form.post(route(`${props.routeName}store`), {
            onBefore: () => {
                setLoading(true);
            },
            onError: () => {
                error422();
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    const updateForm = () => {
        form.post(route(`${props.routeName}update`, academicBody?.id), {
            onBefore: () => {
                setLoading(true);
            },
            onError: () => {
                error422();
            },
            onFinish: () => {
                setLoading(false);
            },
        });
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

    provide("form", form);
    provide("isLoading", isLoading);
    provide("departments", props.departments);
    provide("consolidationDegrees", props.consolidationDegrees);
    provide("academicDisciplines", props.academicDisciplines);
    provide("researchLines", props.researchLines);
    provide("academics", props.academics);
    provide("economicSectors", props.economicSectors);
    provide("oecdSectors", props.oecdSectors);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
        deleteForm,
        enable,
    };
};