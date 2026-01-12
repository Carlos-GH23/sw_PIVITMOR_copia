export const limitList = (list, limit) => {
    if (list.length > limit) {
        limit--;
    }
    return list.slice(0, limit + 1);
};
