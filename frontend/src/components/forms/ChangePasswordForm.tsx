import { ChangePasswordPayload } from "../../common/types.ts";
import { Controller, SubmitHandler, useForm } from "react-hook-form";
import toast from "react-hot-toast";
import { useMutation } from "@tanstack/react-query";
import { useAuthStore } from "../../store/authStore.ts";
import UserService from "../../service/UserService.ts";
import { Box, Button, TextField } from "@mui/material";

type FormValues = ChangePasswordPayload & { repeatPassword: string };

const defaultValues: FormValues = {
  password: "",
  repeatPassword: "",
};

function ChangePasswordForm() {
  const { logout, user } = useAuthStore();
  const { control, handleSubmit, reset, watch } = useForm<FormValues>({ defaultValues });

  if (user === null) return null;

  const { mutate, isPending } = useMutation({
    mutationFn: async ({ id, data }: { id: string; data: ChangePasswordPayload }) => {
      return UserService.changePassword(id, data);
    },
    onSuccess: () => {
      reset();
      toast.success("Password changed");
      logout();
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const onSubmit: SubmitHandler<FormValues> = (data) => {
    mutate({ id: user.id, data: { password: data.password } });
  };

  return (
    <Box sx={{ maxWidth: "600px" }}>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Box sx={{ pb: 2, pt: 1 }}>
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
            render={({ field: { onChange, value }, fieldState: { error } }) => (
              <TextField
                helperText={error ? error.message : null}
                type="password"
                size="small"
                error={!!error}
                onChange={onChange}
                value={value}
                fullWidth
                label="New password"
                variant="outlined"
                disabled={isPending}
              />
            )}
          />
        </Box>
        <Box sx={{ pb: 2, pt: 1 }}>
          <Controller
            name="repeatPassword"
            control={control}
            rules={{
              validate: (value: string) => {
                if (value !== watch("password")) {
                  return "Your passwords don't match";
                }
              },
            }}
            render={({ field: { onChange, value }, fieldState: { error } }) => (
              <TextField
                helperText={error ? error.message : null}
                type="password"
                size="small"
                error={!!error}
                onChange={onChange}
                value={value}
                fullWidth
                label="Repeat password"
                variant="outlined"
                disabled={isPending}
              />
            )}
          />
        </Box>
        <Button variant="contained" type="submit" loading={isPending}>
          Save new password
        </Button>
      </form>
    </Box>
  );
}

export default ChangePasswordForm;
