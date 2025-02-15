import AuthenticatedRequestService from "./AuthenticatedRequestService.ts";
import {Category} from "../common/types.ts";

class CategoryService extends AuthenticatedRequestService {
  public static async getCategories(): Promise<{total: number, items: Category[]}> {
    return await CategoryService.makeRequest<{total: number, items: Category[]}>("GET", "categories");
  }
}

export default CategoryService;