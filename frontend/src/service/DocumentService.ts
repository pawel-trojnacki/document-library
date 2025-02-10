import AuthenticatedRequestService from "./AuthenticatedRequestService";
import { Document } from "../common/types";

class DocumentService extends AuthenticatedRequestService {
  static async getDocuments(): Promise<{total: number, items: Document[]}> {
    return await DocumentService.makeRequest<{total: number, items: Document[]}>("GET", "documents");
  }
}

export default DocumentService;