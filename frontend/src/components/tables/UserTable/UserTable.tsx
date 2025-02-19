import {useQuery, useQueryClient} from "@tanstack/react-query";
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

function UserTable() {
  const queryClient = useQueryClient();

  const {data, isLoading, error} = useQuery({
    queryKey: ["users"],
    queryFn: UserService.getUsers,
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
              <TableCell>Email</TableCell>
              <TableCell>Role</TableCell>
              <TableCell>Created at</TableCell>
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {data?.items.map((user) => (
              <UserRow key={user.id} user={user} />
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </>
  )
}

export default UserTable;