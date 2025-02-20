import {UserDto} from "../../../common/types.ts";
import {IconButton, TableCell, TableRow, Tooltip} from "@mui/material";
import {userRoleVerbose} from "../../../common/functions.ts";
import {Delete as DeleteIcon, Edit as EditIcon} from "@mui/icons-material";
import {useUserStore} from "../../../store/userStore.ts";

type Props = {
  user: UserDto;
  onDelete: () => void;
}

function UserRow({user, onDelete}: Props) {
  const {openModal} = useUserStore();

  return (
    <TableRow
      sx={{ '&:last-child td, &:last-child th': {border: 0} }}
    >
      <TableCell component="th" scope="row">{`${user.firstName} ${user.lastName}`}</TableCell>
      <TableCell>{user.email}</TableCell>
      <TableCell>{userRoleVerbose(user.role)}</TableCell>
      <TableCell>{user.createdAt}</TableCell>
      <TableCell sx={{display: "flex", gap: 1}}>
        <Tooltip title="Edit user">
          <IconButton
            size="small"
            color="secondary"
            onClick={() => openModal(user)}
          >
            <EditIcon />
          </IconButton>
        </Tooltip>
        <Tooltip title="Delete user">
          <IconButton
            size="small"
            color="error"
            onClick={onDelete}
          >
            <DeleteIcon />
          </IconButton>
        </Tooltip>
      </TableCell>
    </TableRow>
  )
}

export default UserRow;