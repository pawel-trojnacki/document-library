import { jwtDecode } from "jwt-decode";
import { User } from "./types";

export function getUserFromToken(token: string): User {
  return jwtDecode(token);
}
