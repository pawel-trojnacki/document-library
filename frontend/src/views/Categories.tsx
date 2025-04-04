import Head from "../components/common/Head.tsx";
import { useAuthStore } from "../store/authStore.ts";
import CategoryTable from "../components/tables/CategoryTable/CategoryTable.tsx";
import { Navigate } from "react-router";
import { Container, Typography } from "@mui/material";

function Categories() {
  const { user } = useAuthStore();

  if (!user?.isAdmin) {
    return <Navigate to="/" />;
  }

  return (
    <>
      <Head title="Categories" />
      <Container maxWidth="lg" sx={{ py: 4 }}>
        <Typography component="h1" variant="h4" sx={{ mb: 4 }}>
          Categories
        </Typography>
        <CategoryTable />
      </Container>
    </>
  );
}

export default Categories;
