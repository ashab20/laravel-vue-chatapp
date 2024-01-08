import axios from "axios";

const baseURL = axios.create({
    baseURL: import.meta.env.APP_URL,
    timeout: 1000,
    headers: { "X-Custom-Header": "foobar" },
});


const baseAPI = axios.create({
    baseURL: `${import.meta.env.APP_URL}/api`,
    timeout: 1000,
    headers: { "X-Custom-Header": "foobar" },
});

export default baseURL;
