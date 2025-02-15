import AuthenticatedRequestService from "./AuthenticatedRequestService";
import { Document } from "../common/types";

class DocumentService extends AuthenticatedRequestService {
  public static async getDocuments(limit: number, from: number): Promise<{total: number, items: Document[]}> {
    return await DocumentService.makeRequest<{total: number, items: Document[]}>(
      "GET",
      `documents?limit=${limit}&from=${from}`
    );
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
}

export default DocumentService;