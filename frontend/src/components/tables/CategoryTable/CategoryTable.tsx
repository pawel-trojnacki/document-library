import {useState} from "react";
import {useQuery, useMutation, useQueryClient} from "@tanstack/react-query";
import toast from "react-hot-toast";
import CategoryService from "../../../service/CategoryService.ts";
import CategoryForm from "../../forms/CategoryForm.tsx";
import {
  Alert,
  Box,
  Button,
  CircularProgress,
  Fab,
  Paper,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow
} from "@mui/material";
import {Add as AddIcon} from "@mui/icons-material";

function CategoryTable() {
  const [isModalOpen, setModalOpen] = useState(false);

  const queryClient = useQueryClient();

  const {data, isLoading, error} = useQuery({
    queryKey: ["categories"],
    queryFn: CategoryService.getCategories,
  });

  const deleteCategoryMutation = useMutation({
    mutationFn: CategoryService.deleteCategory,
    onSuccess: () => {
      queryClient.invalidateQueries({queryKey: ["categories"]});
      toast.success("Category deleted");
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const handleDelete = (id: string) => {
    const confirmation = window.confirm("Are you sure you want to delete this category?");
    if(confirmation) {
      deleteCategoryMutation.mutate(id);
    }
  }

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
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {data?.items.map((category) => (
              <TableRow
                key={category.id}
                sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
              >
                <TableCell component="th" scope="row">
                  {category.name}
                </TableCell>
                <TableCell>
                  <Button
                    onClick={() => handleDelete(category.id)}
                    variant="outlined"
                    color="error"
                    type="submit"
                    disabled={deleteCategoryMutation.isPending}
                  >
                    Delete
                  </Button>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
      <Fab
        onClick={() => setModalOpen(true)}
        color="primary"
        aria-label="Create category"
        sx={{
          position: "fixed",
          bottom: "30px",
          right: "30px",
        }}
      >
        <AddIcon />
      </Fab>
      <CategoryForm
        isOpen={isModalOpen}
        onClose={() => setModalOpen(false)}
      />
    </>
  )
}

export default CategoryTable;