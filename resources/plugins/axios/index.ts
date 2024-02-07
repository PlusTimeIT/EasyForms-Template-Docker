import axios from 'axios';

export default axios.create({
    url: import.meta.env.VITE_BACKEND_URL,
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "application/json",
        "Accept": "application/json",
    }
});
