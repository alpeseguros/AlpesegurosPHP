export async function getMeApi(token) {
    try {
        const url = 'http://127.0.0.1:8000/api/auth/me';
        const params = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };
        console.log(params)
        const response = await fetch(url, params);
        const result = await response.json();  // Invoca la función json() aquí
        return result;

    } catch (error) {
        throw error;
    }
}
