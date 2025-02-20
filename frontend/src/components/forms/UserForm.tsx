import {useEffect} from "react";
import {
  Box,
  Button,
  Dialog,
  DialogContent,
  DialogTitle,
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  TextField
} from "@mui/material";
import {Controller, SubmitHandler, useForm} from "react-hook-form";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import toast from "react-hot-toast";
import {UserPayload} from "../../common/types.ts";
import UserService from "../../service/UserService.ts";
import {useUserStore} from "../../store/userStore.ts";

const defaultValues: UserPayload = {
  email: "",
  firstName: "",
  lastName: "",
  role: "ROLE_USER",
  password: "",
}

function UserForm() {
  const {user, isModalOpen, closeModal} = useUserStore();

  const { control, handleSubmit, reset } = useForm<UserPayload>({defaultValues});
  const queryClient = useQueryClient();

  useEffect(() => {
    if (user) {
      reset({
        email: user.email,
        firstName: user.firstName,
        lastName: user.lastName,
        role: user.role,
        password: "",
      });
    } else {
      reset(defaultValues);
    }
  }, [user, reset]);

  const {mutate, isPending} = useMutation({
    mutationFn: async ({ id, data }: { id: string | null; data: UserPayload }) => {
      if (id) {
        return UserService.editUser(id, data);
      } else {
        return UserService.createUser(data);
      }
    },
    onSuccess: () => {
      reset();
      closeModal();
      queryClient.invalidateQueries({ queryKey: ['users'] });
      toast.success(document ? "User updated" : "User created");
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const onSubmit: SubmitHandler<UserPayload> = (data) => {
      mutate({id: user?.id ?? null, data});
  }

  return (
    <Dialog
      open={isModalOpen}
      onClose={closeModal}
      maxWidth="md"
    >
      <DialogTitle>{document ? "Edit user" : "Create user"}</DialogTitle>
      <DialogContent sx={{minWidth: "500px"}}>
        <form onSubmit={handleSubmit(onSubmit)}>
          <Box sx={{ pb: 2, pt: 1 }}>
            <Controller
              name="email"
              control={control}
              rules={{
                required: "Email is required",
                pattern: {
                  value: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
                  message: "Invalid email address",
                },
              }}
              render={({field: { onChange, value }, fieldState: { error }}) => (
                <TextField
                  helperText={error ? error.message : null}
                  type="email"
                  size="small"
                  error={!!error}
                  onChange={onChange}
                  value={value}
                  fullWidth
                  label="Email"
                  variant="outlined"
                  disabled={isPending}
                />
              )}
            />
          </Box>
          <Box sx={{ pb: 2 }}>
            <Controller
              name="firstName"
              control={control}
              rules={{
                required: "First name is required",
                minLength: {
                  value: 2,
                  message: "First name must be at least 2 characters long",
                },
              }}
              render={({field: { onChange, value }, fieldState: { error }}) => (
                <TextField
                  helperText={error ? error.message : null}
                  type="text"
                  size="small"
                  error={!!error}
                  onChange={onChange}
                  value={value}
                  fullWidth
                  label="First name"
                  variant="outlined"
                  disabled={isPending}
                />
              )}
            />
          </Box>
          <Box sx={{ pb: 2 }}>
            <Controller
              name="lastName"
              control={control}
              rules={{
                required: "Last name is required",
                minLength: {
                  value: 2,
                  message: "Last name must be at least 2 characters long",
                },
              }}
              render={({field: { onChange, value }, fieldState: { error }}) => (
                <TextField
                  helperText={error ? error.message : null}
                  type="text"
                  size="small"
                  error={!!error}
                  onChange={onChange}
                  value={value}
                  fullWidth
                  label="Last name"
                  variant="outlined"
                  disabled={isPending}
                />
              )}
            />
          </Box>
          <Box sx={{ pb: 2 }}>
            <FormControl sx={{ width: "100%" }}>
              <InputLabel htmlFor="role-select">User role</InputLabel>
              <Controller
                name="role"
                control={control}
                render={({field: { onChange, value }}) => (
                  <Select
                    size="small"
                    onChange={onChange}
                    value={value}
                    fullWidth
                    variant="outlined"
                    disabled={isPending}
                  >
                    <MenuItem value="ROLE_USER">User</MenuItem>
                    <MenuItem value="ROLE_ADMIN">Admin</MenuItem>
                  </Select>
                )}
              >

              </Controller>
            </FormControl>
          </Box>
          {!user && (
            <Box sx={{ pb: 2 }}>
              <Controller
                name="password"
                control={control}
                rules={{
                  required: "Password is required",
                  minLength: {
                    value: 8,
                    message: "Password must be at least 8 characters long",
                  },
                }}
                render={({field: { onChange, value }, fieldState: { error }}) => (
                  <TextField
                    helperText={error ? error.message : null}
                    type="password"
                    size="small"
                    error={!!error}
                    onChange={onChange}
                    value={value}
                    fullWidth
                    label="Password"
                    variant="outlined"
                    disabled={isPending}
                  />
                )}
              />
            </Box>
          )}
          <Button
            variant="contained"
            type="submit"
            loading={isPending}
          >
            Save
          </Button>
        </form>
      </DialogContent>
    </Dialog>
  )
}

export default UserForm;