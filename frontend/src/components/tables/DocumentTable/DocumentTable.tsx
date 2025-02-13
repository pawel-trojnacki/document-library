import { useQuery } from "@tanstack/react-query";
import {
  Alert,
  Box,
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
  const {
    data,
    isLoading,
    error
  } = useQuery({queryKey: ["documents"], queryFn: DocumentService.getDocuments});

  if (isLoading) return (
    <Box>
      <CircularProgress />
    </Box>
  )

  if (error) return <Alert severity="error">{error.message}</Alert>

  return (
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
          {data?.items.map((document) => <DocumentRow doc={document} key={document.id} />)}
        </TableBody>
      </Table>
    </TableContainer>
  )
}

export default DocumentTable;