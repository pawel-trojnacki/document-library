import { Container, Paper, Typography } from "@mui/material";
import { useAuthStore } from "../store/authStore.ts";
import Head from "../components/common/Head.tsx";
import ChangePasswordForm from "../components/forms/ChangePasswordForm.tsx";

function Profile() {
  const { user } = useAuthStore();

  return (
    <>
      <Head title="Profile" />
      <Container maxWidth="lg" sx={{ py: 4 }}>
        <Typography component="h1" variant="h4" sx={{ mb: 4 }}>
          {`Hello, ${user?.name}!`}
        </Typography>
        <Paper component="section" variant="outlined" sx={{ p: 3 }}>
          <Typography component="h2" variant="h6" sx={{ mb: 4 }}>
            Change your password
          </Typography>
          <ChangePasswordForm />
        </Paper>
      </Container>
    </>
  );
}

export default Profile;
