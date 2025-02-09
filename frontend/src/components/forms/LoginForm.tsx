import { useState } from 'react';
import { Alert, Box, Button, TextField } from '@mui/material';
import { Controller, useForm, SubmitHandler } from 'react-hook-form';
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
  const [isLoading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const { control, handleSubmit } = useForm<FormValues>({defaultValues});

  const onSubmit: SubmitHandler<FormValues> = async (data) => {
    setError(null);
    setLoading(true);

    try {
      const response = await AuthService.login(data.email, data.password);
      console.log(response);
      setLoading(false);
    } catch (e) {
      setError(e instanceof Error ? e.message : "An error occurred");
      setLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      {error && (
        <Alert severity="error" sx={{ mb: 2 }}>
          {error}
        </Alert>
      )}
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
              autoComplete="username"
              disabled={isLoading}
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
              autoComplete="current-password"
              disabled={isLoading}
              required
            />
          )}
        />
      </Box>
      <Button
        variant="contained"
        type="submit"
        disabled={isLoading}
      >
        Log in
      </Button>
    </form>
  )
}

export default LoginForm;