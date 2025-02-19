import AuthenticatedRequestService from "./AuthenticatedRequestService.ts";
import {ChangePasswordPayload, UserDto, UserPayload} from "../common/types.ts";

class UserService extends AuthenticatedRequestService {
  public static async getUsers(): Promise<{total: number, items: UserDto[]}> {
    return await UserService.makeRequest("GET", "users");
  }

  public static async createUser(payload: UserPayload): Promise<{}> {
    return await UserService.makeRequest<{}>("POST", "users", payload);
  }

  public static async editUser(id: string, payload: UserPayload): Promise<{}> {
    return await UserService.makeRequest<{}>("PATCH", `users/${id}`, payload);
  }

  public static async changePassword(id: string, payload: ChangePasswordPayload): Promise<{}> {
    return await UserService.makeRequest<{}>("PATCH", `users/${id}/change-password`, payload);
  }

  public static async deleteUser(id: string): Promise<{}> {
    return await UserService.makeRequest<{}>("DELETE", `users/${id}`, id);
  }
}

export default UserService;