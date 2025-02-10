import { BrowserRouter, Link, Outlet, Route, Routes, Navigate } from "react-router";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { HelmetProvider } from "react-helmet-async";
import Documents from "./views/Documents.tsx";
import Login from "./views/Login.tsx";
import Users from "./views/Users.tsx";
import CssBaseline from '@mui/material/CssBaseline';
import { useAuthStore } from "./store/authStore.ts";

function AuthenticatedLayout() {
  const { getUser } = useAuthStore();

  if (!getUser()) {
    return <Navigate to="/login" replace />;
  }

  return (
    <div>
      <nav>
        <Link to="/">Documents</Link>
        <Link to="users">Users</Link>
      </nav>
      <Outlet />
    </div>
  )
}

function App() {
  const queryClient = new QueryClient();

  return (
    <QueryClientProvider client={queryClient}>
      <HelmetProvider>
        <CssBaseline />
        <BrowserRouter>
          <Routes>
            <Route element={<AuthenticatedLayout />}>
              <Route index path="/" element={<Documents />} />
              <Route path="/users" element={<Users />} />
            </Route>
            <Route path="/login" element={<Login />} />
          </Routes>
        </BrowserRouter>
      </HelmetProvider>
    </QueryClientProvider>
  )
}

export default App;
