import { Container, Typography } from "@mui/material";
import Head from "../components/common/Head.tsx";
import UserTable from "../components/tables/UserTable/UserTable.tsx";
import { Navigate } from "react-router";
import { useAuthStore } from "../store/authStore.ts";

function Users() {
  const { user } = useAuthStore();

  if (!user?.isAdmin) {
    return <Navigate to="/" />;
  }

  return (
    <>
      <Head title="Users" />
      <Container maxWidth="lg" sx={{ py: 4 }}>
        <Typography component="h1" variant="h4" sx={{ mb: 4 }}>
          Users
        </Typography>
        <UserTable />
      </Container>
    </>
  );
}

export default Users;
