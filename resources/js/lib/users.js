import axios from "axios";
import baseURL from "./base";

async function getAllUsers() {
    const response = await baseURL.get("users.get");
    const { data } = response;
    return data["users"];
}

export { getAllUsers };
