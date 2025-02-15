import {useInfiniteQuery} from "@tanstack/react-query";
import {useSearchParams} from "react-router";
import {
  Alert,
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
import DocumentService from "../../../service/DocumentService.ts";
import DocumentRow from "./DocumentRow.tsx";

function DocumentTable() {
  const [searchParams] = useSearchParams();

  const fetchDocuments = async ({pageParam = 0}) => {
    const perPageParam = searchParams.get("perPage");
    const perPageRaw = perPageParam ? parseInt(perPageParam) : NaN;
    const perPage = Number.isInteger(perPageRaw) ? perPageRaw : 25;
    return await DocumentService.getDocuments(perPage, pageParam);
  }

  const {
    data,
    isLoading,
    error,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
  } = useInfiniteQuery({
    initialData: undefined,
    initialPageParam: 0,
    queryKey: ["documents"],
    queryFn: fetchDocuments,
    getNextPageParam: (lastPage, allPages) => {
      const total = lastPage.total;
      const currentCount = allPages.flatMap((page) => page.items).length;
      return currentCount < total ? currentCount : undefined;
    }
  });

  if (isLoading) return (
    <Box>
      <CircularProgress />
    </Box>
  )

  if (error) return <Alert severity="error">{error.message}</Alert>

  return (
    <>
      <TableContainer component={Paper}>
        <Table sx={{ minWidth: 650 }}>
          <TableHead>
            <TableRow>
              <TableCell>Name</TableCell>
              <TableCell>Category</TableCell>
              <TableCell>Last changes</TableCell>
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {data?.pages.flatMap((page) =>
              page.items.map((doc) => (
                <DocumentRow doc={doc} key={doc.id} />
              ))
            )}
          </TableBody>
        </Table>
      </TableContainer>
      {hasNextPage && (
        <Button
          onClick={() => fetchNextPage()}
          disabled={isFetchingNextPage}
          variant="outlined"
          sx={{mt: 3}}
        >
          {isFetchingNextPage ? "Loading..." : "Load More"}
        </Button>
      )}
    </>
  )
}

export default DocumentTable;