import AuthenticatedRequestService from "./AuthenticatedRequestService.ts";
import { Category, CategoryPayload } from "../common/types.ts";

class CategoryService extends AuthenticatedRequestService {
  public static async getCategories(): Promise<{ total: number; items: Category[] }> {
    return await CategoryService.makeRequest<{ total: number; items: Category[] }>(
      "GET",
      "categories"
    );
  }

  public static async createCategory(payload: CategoryPayload): Promise<{}> {
    return await CategoryService.makeRequest<{}>("POST", "categories", payload);
  }

  public static async deleteCategory(id: string): Promise<{}> {
    return await CategoryService.makeRequest<{}>("DELETE", `categories/${id}`);
  }
}

export default CategoryService;
