import { ref } from "vue";
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", () => {
  const token = ref(localStorage.getItem("token") || "");

  const storedUser = localStorage.getItem("user");
  const user = ref(storedUser ? JSON.parse(storedUser) : null);

  const isAuthenticated = ref(!!token.value);

  function setAuth(data) {
    token.value = data.token;
    user.value = data.user;
    isAuthenticated.value = true;

    localStorage.setItem("token", data.token);
    localStorage.setItem("user", JSON.stringify(data.user));
  }

  function logout() {
    token.value = "";
    user.value = null;
    isAuthenticated.value = false;

    localStorage.removeItem("token");
    localStorage.removeItem("user");
  }

  return {
    token,
    user,
    isAuthenticated,
    setAuth,
    logout,
  };
});