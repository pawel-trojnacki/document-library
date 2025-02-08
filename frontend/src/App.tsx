import {BrowserRouter, Link, Outlet, Route, Routes} from "react-router";
import {HelmetProvider} from "react-helmet-async";
import Documents from "./views/Documents.tsx";
import Login from "./views/Login.tsx";
import Users from "./views/Users.tsx";
import CssBaseline from '@mui/material/CssBaseline';


function AuthenticatedLayout() {
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
  return (
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
  )
}

export default App;
