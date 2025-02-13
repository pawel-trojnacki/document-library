import Head from "../components/common/Head.tsx";
import { Container, Typography } from "@mui/material";
import DocumentTable from "../components/tables/DocumentTable/DocumentTable.tsx";

function Documents() {
    return (
      <>
        <Head />
        <Container maxWidth="lg" sx={{py: 4}}>
          <Typography
            component="h1"
            variant="h4"
            sx={{mb: 4}}
          >
            Documents
          </Typography>
          <DocumentTable />
        </Container>
      </>
    );
}

export default Documents;