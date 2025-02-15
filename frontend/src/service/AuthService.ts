class AuthService {
  public static async login(email: string, password: string): Promise<{token: string, refresh_token: string}> {
    const response = await fetch(`${import.meta.env.VITE_API_URL}/login-check`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({username: email, password}),
    });

    const result = await response.json();

    if (!response.ok) {
      throw new Error(result.message ?? 'Invalid credentials');
    }

    return result;
  }
}

export default AuthService;