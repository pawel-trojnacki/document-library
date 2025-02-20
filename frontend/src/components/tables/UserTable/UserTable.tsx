import {useMutation, useQuery, useQueryClient} from "@tanstack/react-query";
import {
  Alert,
  Box,
  CircularProgress,
  Paper,
  TableCell,
  Table,
  TableBody,
  TableContainer,
  TableHead,
  TableRow
} from "@mui/material";
import UserService from "../../../service/UserService.ts";
import UserRow from "./UserRow.tsx";
import FloatingActionButton from "../../ui/FloatingActionButton.tsx";
import UserForm from "../../forms/UserForm.tsx";
import {useUserStore} from "../../../store/userStore.ts";
import DocumentService from "../../../service/DocumentService.ts";
import toast from "react-hot-toast";

function UserTable() {
  const {openModal} = useUserStore();
  const queryClient = useQueryClient();

  const {data, isLoading, error} = useQuery({
    queryKey: ["users"],
    queryFn: UserService.getUsers,
  });

  const deleteUserMutation = useMutation({
    mutationFn: UserService.deleteUser,
    onSuccess: () => {
      queryClient.invalidateQueries({queryKey: ["users"]});
      toast.success("User deleted");
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const handleDelete = (id: string) => {
    const confirmation = window.confirm("Are you sure you want to delete this user?");
    if(confirmation) {
      deleteUserMutation.mutate(id);
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
              <TableCell>Email</TableCell>
              <TableCell>Role</TableCell>
              <TableCell>Created at</TableCell>
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {data?.items.map((user) => (
              <UserRow key={user.id} user={user} onDelete={() => handleDelete(user.id)} />
            ))}
          </TableBody>
        </Table>
      </TableContainer>
      <FloatingActionButton ariaLabel="Create user" onClick={() => openModal(null)} />
      <UserForm />
    </>
  )
}

export default UserTable;