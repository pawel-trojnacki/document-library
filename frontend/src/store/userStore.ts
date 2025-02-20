import {create} from "zustand";
import {UserDto} from "../common/types.ts";

type State = {
  user: UserDto | null;
  isModalOpen: boolean;
}

type Actions = {
  openModal: (user: UserDto | null) => void;
  closeModal: () => void;
}

export const useUserStore = create<State & Actions>((set) => ({
  user: null,
  isModalOpen: false,
  openModal: (user) => set({user, isModalOpen: true}),
  closeModal: () => set({user: null, isModalOpen: false}),
}))