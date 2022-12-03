
import axios from "axios";

const API_URL = "http://localhost:4000/api/auth/";

class AuthService {
	login(username: string, password: string) {
		return axios
			.post(API_URL + "login", {
				username,
				password
			})
			.then(response => {
				if (response.data.accessToken) {
					
					localStorage.setItem("user", JSON.stringify(response.data));
				}

				return response.data;
			});
	}

	logout() {
		localStorage.removeItem("user");
	}

	register(email: string, password: string, username: string, name:string) {
		return axios.post(API_URL + "register", {
			email,
			password,
			username,
			name
		});
	}

	refresh() {
		return axios
			.post(API_URL + "refresh")
			.then(response => {
				if (response.data.accessToken) {
					
					localStorage.setItem("newToken", JSON.stringify(response.data));
				}

				return response.data;
			});
	}

	getCurrentUser() {
		const userStr = localStorage.getItem("user");
		if (userStr) return JSON.parse(userStr);

		return null;
	}
}

export default new AuthService();