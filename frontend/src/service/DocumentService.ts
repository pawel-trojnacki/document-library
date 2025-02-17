import AuthenticatedRequestService from "./AuthenticatedRequestService";
import {Document, DocumentPayload} from "../common/types";

class DocumentService extends AuthenticatedRequestService {
  public static async getDocuments(
    limit: number,
    from: number,
    categoryId: string | null = null,
    search: string | null = null,
  ): Promise<{total: number, items: Document[]}> {
    let params = `limit=${limit}&from=${from}`;
    if (categoryId) {
      params += `&categoryId=${categoryId}`;
    }
    if (search) {
      params += `&search=${search}`;
    }

    return await DocumentService.makeRequest<{total: number, items: Document[]}>("GET", `documents?${params}`);
  }

  public static async downloadFile(id: string): Promise<Response> {
    return await DocumentService.makeRequest<Response>(
      "GET",
      `documents/${id}/file`,
      null,
      "application/octet-stream",
      true,
      true,
    );
  }

  public static async createDocument(data: FormData): Promise<{}> {
    return await DocumentService.makeRequest<{}>("POST", "documents", data, null);
  }

  public static async editDocument({id, data}: {id: string; data: DocumentPayload}): Promise<{}> {
    return await DocumentService.makeRequest<{}>("PATCH", `documents/${id}`, data);
  }

  public static async deleteDocument(id: string): Promise<{}> {
    return await DocumentService.makeRequest<{}>("DELETE", `documents/${id}`);
  }
}

export default DocumentService;