import { BrowserRouter, Outlet, Route, Routes, Navigate } from "react-router";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { HelmetProvider } from "react-helmet-async";
import { Toaster } from "react-hot-toast";
import CssBaseline from "@mui/material/CssBaseline";
import { createTheme, ThemeProvider } from "@mui/material";
import { blue, deepPurple } from "@mui/material/colors";
import { useAuthStore } from "./store/authStore.ts";
import Navbar from "./components/layout/Navbar.tsx";
import Documents from "./views/Documents.tsx";
import Login from "./views/Login.tsx";
import Categories from "./views/Categories.tsx";
import Users from "./views/Users.tsx";
import Profile from "./views/Profile.tsx";

const theme = createTheme({
  palette: {
    primary: deepPurple,
    secondary: blue,
  },
});

function AuthenticatedLayout() {
  const { user } = useAuthStore();

  if (!user) {
    return <Navigate to="/login" replace />;
  }

  return (
    <div>
      <Navbar />
      <Outlet />
    </div>
  );
}

function App() {
  const queryClient = new QueryClient();

  return (
    <QueryClientProvider client={queryClient}>
      <HelmetProvider>
        <ThemeProvider theme={theme}>
          <CssBaseline />
          <BrowserRouter>
            <Routes>
              <Route element={<AuthenticatedLayout />}>
                <Route index path="/" element={<Documents />} />
                <Route path="/profile" element={<Profile />} />
                <Route path="/categories" element={<Categories />} />
                <Route path="/users" element={<Users />} />
              </Route>
              <Route path="/login" element={<Login />} />
            </Routes>
          </BrowserRouter>
          <Toaster position="top-right" />
        </ThemeProvider>
      </HelmetProvider>
    </QueryClientProvider>
  );
}

export default App;
