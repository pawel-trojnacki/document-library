import {useState} from "react";
import {Box, Button, Chip, Collapse, IconButton, TableCell, TableRow, Typography} from "@mui/material";
import {
  Download as DownloadIcon,
  KeyboardArrowDown as KeyboardArrowDownIcon,
  KeyboardArrowUp as KeyboardArrowUpIcon,
} from '@mui/icons-material';
import toast from "react-hot-toast";
import {Document} from "../../../common/types.ts";
import {getFileTypeDetails, downloadFile} from "../../../common/functions.ts";
import DocumentService from "../../../service/DocumentService.ts";

type Props = {
  doc: Document
};

function DocumentRow({ doc }: Props) {
  const typeDetails = getFileTypeDetails(doc.fileType);

  const [isDetailsOpen, setDetailsOpen] = useState(false);

  const handleDownload = async () => {
    try {
      const response = await DocumentService.downloadFile(doc.id);
      await downloadFile(response, doc.originalName);
    } catch (error) {
      if (error instanceof Error) {
        toast.error(error.message);
      } else {
        toast.error("Couldn't download file");
      }
    }
  }

  const handleToggleDetails = () => {
    setDetailsOpen(!isDetailsOpen);
  }

  return (
    <>
      <TableRow
        key={doc.id}
        sx={{'& > *': {borderBottom: "0 !important"}}}
      >
        <TableCell>
          <IconButton
            aria-label="Expand setails"
            size="small"
            onClick={handleToggleDetails}
          >
            {isDetailsOpen ? <KeyboardArrowUpIcon /> : <KeyboardArrowDownIcon />}
          </IconButton>
        </TableCell>
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
        <TableCell>{doc.authorName ?? ''}</TableCell>
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
      <TableRow
        sx={{'&:last-child td, &:last-child th': {border: 0}}}
      >
        <TableCell sx={{pb: 0, pt: 0}} colSpan={6}>
          <Collapse in={isDetailsOpen} timeout="auto" unmountOnExit>
            <Box sx={{margin: 1, pb: 2, pl: "50px"}}>
              <Box>{doc.description || 'No description provided'}</Box>
            </Box>
          </Collapse>
        </TableCell>
      </TableRow>
    </>
  );
}

export default DocumentRow;