const TOKEN_KEY = 'access_token'
const USER_ID_KEY = 'userId'
const USER = 'user'

const TokenService = {
	getToken() {
		return localStorage.getItem(TOKEN_KEY);
	},

	saveToken(token) {
		localStorage.setItem(TOKEN_KEY, token);
	},

	saveCurrentUserId(id){
		localStorage.setItem(USER_ID_KEY, id);
	},

	saveCurrentUser(user){
		localStorage.setItem(USER, JSON.stringify(user));
	},

	getCurrentUser(){
		let data = JSON.parse(localStorage.getItem(USER));
		return data;
	},

	removeCurrentUser(){
		localStorage.removeItem(USER);
	},

	removeToken() {
		localStorage.removeItem(TOKEN_KEY);
	},

	removeCurrentUserId() {
		localStorage.removeItem(USER_ID_KEY);
	}
};

export {TokenService}
