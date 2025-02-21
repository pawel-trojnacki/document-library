import { Fab } from "@mui/material";
import { Add as AddIcon } from "@mui/icons-material";

type Props = {
  ariaLabel: string;
  onClick: () => void;
};

function FloatingActionButton({ ariaLabel, onClick }: Props) {
  return (
    <Fab
      onClick={onClick}
      color="primary"
      aria-label={ariaLabel}
      sx={{
        position: "fixed",
        bottom: "30px",
        right: "30px",
      }}
    >
      <AddIcon />
    </Fab>
  );
}

export default FloatingActionButton;
