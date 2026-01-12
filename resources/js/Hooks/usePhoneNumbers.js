export const usePhoneNumbers = (phones) => {
    const addPhone = () => {
        phones.value.push({
            id: null,
            number: "",
            dial_code: "",
            type: null,
        });
    };

    const removePhone = (index) => {
        phones.value.splice(index, 1);
    };

    return {
        addPhone,
        removePhone,
    };
};
