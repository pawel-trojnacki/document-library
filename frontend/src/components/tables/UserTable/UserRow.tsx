import {UserDto} from "../../../common/types.ts";
import {TableCell, TableRow} from "@mui/material";
import {userRoleVerbose} from "../../../common/functions.ts";

type Props = {
  user: UserDto;
}

function UserRow({user} = Props) {
  return (
    <TableRow
      sx={{ '&:last-child td, &:last-child th': {border: 0} }}
    >
      <TableCell component="th" scope="row">{user.name}</TableCell>
      <TableCell>{user.email}</TableCell>
      <TableCell>{userRoleVerbose(user.role)}</TableCell>
      <TableCell>{user.createdAt}</TableCell>
      <TableCell></TableCell>
    </TableRow>
  )
}

export default UserRow;