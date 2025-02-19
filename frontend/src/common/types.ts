export type UserRole = "ROLE_ADMIN" | "ROLE_USER";

export type User = {
  id: string;
  username: string;
  email: string;
  name: string;
  role: string;
  isAdmin: boolean;
}

export type UserPayload = {
  email: string;
  firstName: string;
  lastName: string;
  role: UserRole;
  password: string;
}

export type ChangePasswordPayload = {
  password: string;
}

export type UserDto = {
  id: string;
  email: string;
  name: string;
  role: UserRole;
  createdAt: string;
}

export type FileType = "doc" | "docx" | "xls" | "xlsx" | "pdf";

export type FileTypeDetails = {
  label: string;
  color: string;
}

export type Document = {
  id: string;
  createdAt: string;
  updatedAt: string;
  fileType: FileType;
  originalName: string;
  name: string;
  description: string | null;
  categoryId: string | null;
  categoryName: string | null;
  authorId: string;
  authorName: string;
}

export type Category = {
  id: string;
  name: string; 
}

export type CategoryPayload = {
  name: string;
}

export type DocumentPayload = {
  name: string;
  description: string;
  categoryId: string | null;
  file: File | null;
}