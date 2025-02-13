import {Document} from "../../../common/types.ts";
import {getFileTypeDetails, downloadFile} from "../../../common/functions.ts";
import DocumentService from "../../../service/DocumentService.ts";
import {Button, Chip, TableCell, TableRow, Typography} from "@mui/material";
import { Download as DownloadIcon } from '@mui/icons-material';

type Props = {
  doc: Document
};

function DocumentRow({ doc }: Props) {
  const typeDetails = getFileTypeDetails(doc.fileType);

  const handleDownload = async () => {
    try {
      const response = await DocumentService.downloadFile(doc.id);
      await downloadFile(response, doc.originalName);
    } catch (error) {
      // TODO handle error
      console.log(error);
    }
  }

  return (
    <TableRow
      key={doc.id}
      sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
    >
      <TableCell component="th" scope="row">
        <Typography
          sx={{mb: "6px"}}
        >
          {doc.name}
        </Typography>
        <Chip
          label={typeDetails.label}
          sx={{
            backgroundColor: typeDetails.color,
            color: "#FFF",
            height: "22px",
            fontSize: "0.75rem",
          }}
        />
      </TableCell>
      <TableCell>{doc.categoryName ?? ''}</TableCell>
      <TableCell>{doc.updatedAt}</TableCell>
      <TableCell>
        <Button
          size="small"
          variant="contained"
          startIcon={<DownloadIcon />}
          onClick={handleDownload}
        >
          Download
        </Button>
      </TableCell>
    </TableRow>
  );
}

export default DocumentRow;