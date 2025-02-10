import { useQuery } from "@tanstack/react-query";
import Head from "../components/common/Head.tsx";
import DocumentService from "../service/DocumentService.ts";

function Documents() {
  const {
    data,
  } = useQuery({queryKey: ["documents"], queryFn: DocumentService.getDocuments});
    return (
      <>
        <Head />
        <div>
          <h1>Documents</h1>
          {data?.items.map((document) => (
            <div key={document.id}>
              <h2>{document.name}</h2>
            </div>
          ))}
        </div>
      </>
    );
}

export default Documents;