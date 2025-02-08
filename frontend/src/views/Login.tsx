import Head from "../components/common/Head.tsx";
import { Box, Container, Paper, Typography } from "@mui/material";
import LoginForm from "../components/forms/LoginForm.tsx";

function Login() {
  return (
    <>
      <Head title="Login" />
      <Box sx={{ py: 4, bgcolor: '#e3f2fd', minHeight: '100vh' }}>
        <Container maxWidth="sm">
          <Typography
            variant="h4"
            component="h1"
            sx={{ textAlign: "center", mb: 4 }}
          >
            Welcome to Document Library!
          </Typography>
          <Paper elevation={0}>
            <Box sx={{ py: 4, px: 3 }}>
              <LoginForm />
            </Box>
          </Paper>
        </Container>
      </Box>
    </>
  );
}

export default Login;