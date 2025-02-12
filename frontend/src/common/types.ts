export type User = {
  id: string;
  username: string;
  email: string;
  name: string;
  role: string;
  isAdmin: boolean;
}

export type Document = {
  id: string;
  name: string;
  content: string;
  createdAt: string;
  updatedAt: string;
}
