import { useAuthStore } from "../store/authStore";

abstract class AuthenticatedRequestService {
  protected static async makeRequest<T>(
    method: string,
    url: string,
    body?: any,
    contentType: string = "application/json",
    allowRefreshToken: boolean = true,
    returnRaw: boolean = false,
  ): Promise<T> {
    const token = useAuthStore.getState().getToken();

    if (!token) {
      throw new Error("No token found");
    }

    const params = {
      method,
      headers: {
        "Content-Type": contentType,
        Authorization: `Bearer ${token}`,
      },
      body: undefined,
    }

    if (body) {
      params.body = contentType === "application/json" ? JSON.stringify(body) : body;
    }

    const response = await fetch(`${import.meta.env.VITE_API_URL}/${url}`, params);

    if (response.ok) {
      return returnRaw ? response : await response.json();
    }

    if (response.status === 401 && allowRefreshToken) {
      const refreshToken = useAuthStore.getState().getRefreshToken();
      const refreshResponse = await fetch(`${import.meta.env.VITE_API_URL}/refresh-token`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({refresh_token: refreshToken}),
      });

      if (!refreshResponse.ok) {
        throw new Error("Refresh token failed");
      }

      const refreshData = await refreshResponse.json();
      useAuthStore.getState().login(refreshData.token, refreshData.refresh_token);

      return AuthenticatedRequestService.makeRequest(method, url, body, contentType, false, returnRaw);
    }

    const errorResponse = await response.json();

    throw new Error(errorResponse?.message ?? response.statusText ?? "Unknown error occurred");
  }
}

export default AuthenticatedRequestService;