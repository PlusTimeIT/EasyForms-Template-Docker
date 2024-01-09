import axios from 'axios';

export default axios.create({
    url: import.meta.env.VITE_BACKEND_URL,
    withCredentials: true,
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "application/json",
        "Accept": "application/json",
    }
});
