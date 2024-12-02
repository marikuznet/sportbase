import axios from 'axios';

// Получение base64-строки изображения
export async function getImageBase64(fullPath) {
    const response = await fetch(fullPath);
    const blob = await response.blob();
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.readAsDataURL(blob);
    });
}

// Проверка размера и типа изображения
export function validateImage(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => {
            const image = new Image();
            image.src = reader.result;
            image.onload = () => {
                if (file.size > 5 * 1024 * 1024) {
                    reject('Размер файла не должен превышать 5 МБ. Попробуйте сжать изображение');
                } else if (image.width >= 500 && image.height >= 500 && ['image/jpeg', 'image/png'].includes(file.type)) {
                    resolve();
                } else {
                    reject('Формат фотографий - не менее 500px по широкой и узкой стороне / jpg или png без alpha канала');
                }
            };
        };
        reader.readAsDataURL(file);
    });
}
