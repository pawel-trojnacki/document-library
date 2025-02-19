import {Container, Typography} from "@mui/material";
import Head from "../components/common/Head.tsx";
import UserTable from "../components/tables/UserTable/UserTable.tsx";

function Users() {
    return (
      <>
        <Head title="Users" />
        <Container maxWidth="lg" sx={{py: 4}}>
          <Typography
            component="h1"
            variant="h4"
            sx={{mb: 4}}
          >
            Users
          </Typography>
          <UserTable />
        </Container>
      </>
    )
}

export default Users;