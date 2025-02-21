import { useInfiniteQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { useSearchParams } from "react-router";
import {
  Alert,
  Backdrop,
  Box,
  Button,
  CircularProgress,
  Paper,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
} from "@mui/material";
import toast from "react-hot-toast";
import DocumentService from "../../../service/DocumentService.ts";
import DocumentRow from "./DocumentRow.tsx";
import DocumentFilters from "./DocumentFilters.tsx";
import FloatingActionButton from "../../ui/FloatingActionButton.tsx";
import DocumentForm from "../../forms/DocumentForm.tsx";
import { useAuthStore } from "../../../store/authStore.ts";
import { useDocumentStore } from "../../../store/documentStore.ts";
import { downloadFile } from "../../../common/functions.ts";

function DocumentTable() {
  const { user } = useAuthStore();
  const { openModal } = useDocumentStore();
  const queryClient = useQueryClient();

  const [searchParams] = useSearchParams();

  const fetchDocuments = async ({ pageParam = 0 }) => {
    const perPageParam = searchParams.get("perPage");
    const perPageRaw = perPageParam ? parseInt(perPageParam) : NaN;
    const perPage = Number.isInteger(perPageRaw) ? perPageRaw : 20;
    const categoryId = searchParams.get("categoryId");
    const search = searchParams.get("search");

    return await DocumentService.getDocuments(perPage, pageParam, categoryId, search);
  };

  const { data, isLoading, error, fetchNextPage, hasNextPage, isFetchingNextPage } =
    useInfiniteQuery({
      initialData: undefined,
      initialPageParam: 0,
      queryKey: [
        "documents",
        searchParams.get("categoryId") || "",
        searchParams.get("search") || "",
      ],
      queryFn: fetchDocuments,
      getNextPageParam: (lastPage, allPages) => {
        const total = lastPage.total;
        const currentCount = allPages.flatMap((page) => page.items).length;
        return currentCount < total ? currentCount : undefined;
      },
    });

  const deleteDocumentMutation = useMutation({
    mutationFn: DocumentService.deleteDocument,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["documents"] });
      toast.success("Document deleted");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const handleDelete = (id: string) => {
    const confirmation = window.confirm("Are you sure you want to delete this document?");
    if (confirmation) {
      deleteDocumentMutation.mutate(id);
    }
  };

  const handleDownload = async (id: string, filename: string) => {
    try {
      const response = await DocumentService.downloadFile(id);
      await downloadFile(response, filename);
    } catch (error) {
      if (error instanceof Error) {
        toast.error(error.message);
      } else {
        toast.error("Couldn't download file");
      }
    }
  };

  if (isLoading)
    return (
      <Box>
        <CircularProgress />
      </Box>
    );

  if (error) return <Alert severity="error">{error.message}</Alert>;

  return (
    <>
      <DocumentFilters />
      <TableContainer component={Paper}>
        <Table sx={{ minWidth: 650 }}>
          <TableHead>
            <TableRow>
              <TableCell sx={{ width: "50px" }} />
              <TableCell>Name</TableCell>
              <TableCell>Category</TableCell>
              <TableCell>Author</TableCell>
              <TableCell>Last changes</TableCell>
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {data?.pages.length > 0 && data.pages.some((page) => page.items.length > 0) ? (
              data.pages.flatMap((page) =>
                page.items.map((doc) => (
                  <DocumentRow
                    key={doc.id}
                    doc={doc}
                    onDelete={() => handleDelete(doc.id)}
                    onDownload={() => handleDownload(doc.id, doc.originalName)}
                  />
                ))
              )
            ) : (
              <TableRow>
                <TableCell colSpan={4}>No documents found.</TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </TableContainer>
      {hasNextPage && (
        <Button
          onClick={() => fetchNextPage()}
          loading={isFetchingNextPage}
          variant="outlined"
          sx={{ mt: 3 }}
        >
          Load more
        </Button>
      )}
      {user?.isAdmin && (
        <>
          <FloatingActionButton ariaLabel="Create document" onClick={() => openModal(null)} />
          <DocumentForm />
        </>
      )}
      <Backdrop open={deleteDocumentMutation.isPending}>
        <CircularProgress sx={{ color: "#FFF" }} />
      </Backdrop>
    </>
  );
}

export default DocumentTable;
