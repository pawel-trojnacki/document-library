import {useState} from "react";
import {Box, Chip, Collapse, IconButton, TableCell, TableRow, Tooltip, Typography} from "@mui/material";
import {
  Delete as DeleteIcon,
  Download as DownloadIcon,
  KeyboardArrowDown as KeyboardArrowDownIcon,
  KeyboardArrowUp as KeyboardArrowUpIcon,
} from '@mui/icons-material';
import toast from "react-hot-toast";
import {Document} from "../../../common/types.ts";
import {getFileTypeDetails, downloadFile} from "../../../common/functions.ts";
import DocumentService from "../../../service/DocumentService.ts";
import {useAuthStore} from "../../../store/authStore.ts";

type Props = {
  doc: Document,
  handleDelete: () => void;
};

function DocumentRow({ doc, handleDelete }: Props) {
  const typeDetails = getFileTypeDetails(doc.fileType);
  const {user} = useAuthStore();
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
            size="small"
            aria-label="Expand document details"
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
        <TableCell sx={{display: "flex", gap: 1}}>
          <Tooltip title="Download file">
            <IconButton
              size="small"
              color="primary"
              onClick={handleDownload}
            >
              <DownloadIcon />
            </IconButton>
          </Tooltip>
          {user?.isAdmin && (
            <>
              <Tooltip title="Delete file">
                <IconButton
                  size="small"
                  color="error"
                  onClick={handleDelete}
                >
                  <DeleteIcon />
                </IconButton>
              </Tooltip>
            </>
          )}
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