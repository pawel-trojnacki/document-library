import {Box, Button, TextField} from '@mui/material';
import {Controller, useForm, SubmitHandler} from 'react-hook-form';
import AuthService from "../../service/AuthService.tsx";

type FormValues = {
  email: string;
  password: string;
}

const defaultValues: FormValues = {
  email: "",
  password: "",
}

function LoginForm() {
  const { control, handleSubmit } = useForm<FormValues>({defaultValues});
  const onSubmit: SubmitHandler<FormValues> = async (data) => {
    const response = await AuthService.login(data.email, data.password);
    console.log(response);
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <Box sx={{ pb: 2 }}>
        <Controller
          name="email"
          control={control}
          render={({field: { onChange, value }, fieldState: { error }}) => (
            <TextField
              helperText={error ? error.message : null}
              type="email"
              size="small"
              error={!!error}
              onChange={onChange}
              value={value}
              fullWidth
              label="E-mail"
              variant="outlined"
              required
            />
          )}
        />
      </Box>
      <Box sx={{ pb: 2 }}>
        <Controller
          name="password"
          control={control}
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
              required
            />
          )}
        />
      </Box>
      <Button variant="contained" type="submit">Log in</Button>
    </form>
  )
}

export default LoginForm;