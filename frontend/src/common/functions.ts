import { jwtDecode } from "jwt-decode";
import { FileType, FileTypeDetails, User, UserRole } from "./types";

export function getUserFromToken(token: string): User {
  return jwtDecode(token);
}

export function getFileTypeDetails(type: FileType): FileTypeDetails {
  switch (type) {
    case "pdf":
      return { label: "PDF", color: "#D32F2F" };
    case "xls":
    case "xlsx":
      return { label: "Excel", color: "#2E7D32" };
    case "doc":
    case "docx":
      return { label: "Word", color: "#1976D2" };
  }
}

export async function downloadFile(response: Response, name: string): Promise<void> {
  const blob = await response.blob();
  const url = window.URL.createObjectURL(blob);

  const a = document.createElement("a");
  a.href = url;
  a.download = name;
  document.body.appendChild(a);
  a.click();

  window.URL.revokeObjectURL(url);
  document.body.removeChild(a);
}

export function userRoleVerbose(role: UserRole): string {
  switch (role) {
    case "ROLE_ADMIN":
      return "Admin";
    case "ROLE_USER":
      return "User";
  }
}
