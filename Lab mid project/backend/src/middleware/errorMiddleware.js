export function notFoundHandler(req, res) {
  res.status(404).json({ message: "Route not found" });
}

// eslint-disable-next-line no-unused-vars
export function errorHandler(err, req, res, next) {
  const status = Number(err.statusCode || err.status || 500);
  const message =
    err?.isJoi ? err.details?.[0]?.message ?? "Validation error" : err.message ?? "Server error";

  res.status(status).json({
    message,
    ...(process.env.NODE_ENV === "development" ? { stack: err.stack } : {})
  });
}

