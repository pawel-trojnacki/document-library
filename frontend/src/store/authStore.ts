import {create} from "zustand";
import {persist} from "zustand/middleware";
import {User} from "../common/types.ts";
import {getUserFromToken} from "../common/functions.ts";

type AuthStore = {
  user: User | null;
  token: string | null;
  refreshToken: string | null;
  login: (token: string, refreshToken: string) => void;
  logout: () => void;
}

export const useAuthStore = create<AuthStore>()(
  persist(
    (set) => ({
      user: null,
      token: null,
      refreshToken: null,
      login: (token: string, refreshToken: string) => {
        const user = getUserFromToken(token);
        set({token, refreshToken, user});
      },
      logout: () => set({user: null, token: null, refreshToken: null}),
    }),
    {
      name: "auth-store",
    }
  )
);