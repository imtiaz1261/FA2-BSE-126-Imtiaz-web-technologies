import { apiRequest } from "./client";

export function loginSeller({ email, password }) {
  return apiRequest("/auth/login", {
    method: "POST",
    body: JSON.stringify({ email, password })
  });
}

export function getSellerMetrics(token) {
  return apiRequest("/dashboard/seller/metrics", { token });
}

export function getSellerReport(token, params = {}) {
  const query = new URLSearchParams();
  if (params.from) query.set("from", params.from);
  if (params.to) query.set("to", params.to);
  const suffix = query.toString() ? `?${query.toString()}` : "";

  return apiRequest(`/dashboard/seller/report${suffix}`, { token });
}
