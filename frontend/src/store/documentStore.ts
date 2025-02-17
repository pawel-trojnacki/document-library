import {create} from "zustand";
import {Document} from "../common/types.ts";

type State = {
  document: Document | null;
  isModalOpen: boolean;
}

type Actions = {
  openModal: (document: Document | null) => void;
  closeModal: () => void;
}

export const useDocumentStore = create<State & Actions>((set) => ({
  document: null,
  isModalOpen: false,
  openModal: (document) => set({document, isModalOpen: true}),
  closeModal: () => set({document: null, isModalOpen: false}),
}))