const localStorageHelper = {
    getItem(key) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : null;
        } catch (error) {
            console.error('Ошибка при извлечении данных из localStorage:', error);
            return null;
        }
    },

    setItem(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.error('Ошибка при сохранении данных в localStorage:', error);
        }
    },
};

export default localStorageHelper;
