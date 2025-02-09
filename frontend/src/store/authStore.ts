import { create } from "zustand";
import { User } from "../common/types.ts";
import { getUserFromToken } from "../common/functions.ts";

type AuthStore = {
  user: User | null;
  login: (token: string, refreshToken: string) => void;
  logout: () => void;
  getUser: () => User | null;
  getToken: () => string | null;
  getRefreshToken: () => string | null;
}

export const useAuthStore = create<AuthStore>((set, get) => ({
  user: null,
  login: (token, refreshToken) => {
    const user = getUserFromToken(token);
    set({ user });
    localStorage.setItem("token", token);
    localStorage.setItem("refreshToken", refreshToken);
  },
  logout: () => {
    set({ user: null });
    localStorage.removeItem("token");
    localStorage.removeItem("refreshToken");
  },
  getUser: () => {
    const user = get().user;
    if (user) {
      return user;
    }

    const token = localStorage.getItem("token");
    if (!token) {
      return null;
    }

    set({ user: getUserFromToken(token) });
    return get().user;
  },
  getToken: () => {
    return localStorage.getItem("token");
  },
  getRefreshToken: () => {
    return localStorage.getItem("refreshToken");
  },
}));