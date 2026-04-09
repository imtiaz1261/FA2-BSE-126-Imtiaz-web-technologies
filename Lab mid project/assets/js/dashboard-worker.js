function updateBookingStatus(bookingId, nextStatus, workerId) {
  const bookings = getBookings();
  const index = bookings.findIndex((booking) => booking.id === bookingId);
  if (index < 0) return;
  if (bookings[index].status === "cancelled") return;

  bookings[index].status = nextStatus;
  if (nextStatus === "completed" && !bookings[index].rating) {
    bookings[index].rating = 4.7;
    bookings[index].review = "Work completed successfully.";
  }
  bookings[index].updatedAt = new Date().toISOString();
  saveBookings(bookings);

  const service = getServiceById(bookings[index].serviceId);
  logWorkerActivity(workerId, `${nextStatus.toUpperCase()}: ${service ? service.title : "Service"} booking updated`);
  renderWorkerDashboard(workerId);
}

function calcEarnings(bookings) {
  return bookings
    .filter((booking) => booking.status === "completed")
    .reduce((sum, booking) => {
      const service = getServiceById(booking.serviceId);
      return sum + (service ? service.price : 0);
    }, 0);
}

function renderWorkerDashboard(workerId) {
  const rows = getBookings().filter((booking) => booking.workerId === workerId);
  const pending = rows.filter((booking) => booking.status === "pending");
  const completed = rows.filter((booking) => booking.status === "completed");
  const earnings = calcEarnings(rows);

  const stats = document.getElementById("workerStats");
  stats.innerHTML = `
    <article class="card stat-card"><p class="muted">📦 Total Bookings</p><h3>${rows.length}</h3></article>
    <article class="card stat-card"><p class="muted">✅ Completed Tasks</p><h3>${completed.length}</h3></article>
    <article class="card stat-card"><p class="muted">⏳ Pending Requests</p><h3>${pending.length}</h3></article>
    <article class="card stat-card"><p class="muted">💰 Earnings (UI)</p><h3>$${earnings.toFixed(0)}</h3></article>
  `;

  const pendingBox = document.getElementById("pendingRequests");
  pendingBox.innerHTML = pending.length
    ? pending
        .map((booking) => {
          const service = getServiceById(booking.serviceId);
          const customer = getUserById(booking.userId);
          return `
            <article class="card">
              <div class="section-title">
                <strong>${service ? service.title : "Service"}</strong>
                <span class="status-pill status-pending">${booking.status}</span>
              </div>
              <p class="muted">${booking.date} ${booking.time} · ${customer ? customer.name : "Customer"}</p>
              <p class="muted">Address: ${booking.customerAddress || "Not provided"}</p>
              <div class="row-2 mt-1">
                <button class="btn success" data-action="accept" data-booking-id="${booking.id}">Accept</button>
                <button class="btn danger" data-action="reject" data-booking-id="${booking.id}">Reject</button>
              </div>
            </article>
          `;
        })
        .join("")
    : `<div class="card muted">No pending requests.</div>`;

  const completedBox = document.getElementById("completedJobs");
  completedBox.innerHTML = completed.length
    ? completed
        .map((booking) => {
          const service = getServiceById(booking.serviceId);
          const customer = getUserById(booking.userId);
          return `
            <article class="card">
              <div class="section-title">
                <strong>${service ? service.title : "Service"}</strong>
                <span class="status-pill status-completed">completed</span>
              </div>
              <p class="muted">Customer: ${customer ? customer.name : "Unknown"} · ${booking.date}</p>
              <p><span class="rating">${stars(booking.rating || 4.5)}</span> · ${booking.review || "Great service experience."}</p>
            </article>
          `;
        })
        .join("")
    : `<div class="card muted">No completed jobs yet.</div>`;

  const detailsBox = document.getElementById("bookingDetails");
  detailsBox.innerHTML = rows.length
    ? rows
        .map((booking) => {
          const service = getServiceById(booking.serviceId);
          const customer = getUserById(booking.userId);
          const canComplete = booking.status === "accepted";
          return `
            <article class="card">
              <div class="section-title">
                <strong>${service ? service.title : "Service"}</strong>
                <span class="status-pill status-${booking.status}">${booking.status}</span>
              </div>
              <p class="muted">${booking.date} ${booking.time}</p>
              <p class="muted">Customer: ${customer ? customer.name : "Unknown"} | ${booking.customerAddress || "Address missing"}</p>
              ${canComplete ? `<button class="btn primary mt-1" data-action="complete" data-booking-id="${booking.id}">Mark Completed</button>` : ""}
            </article>
          `;
        })
        .join("")
    : `<div class="card muted">No booking details found.</div>`;

  const logs = getWorkerActivity().filter((entry) => entry.workerId === workerId).slice(0, 8);
  const logsBox = document.getElementById("activityLogs");
  logsBox.innerHTML = logs.length
    ? logs
        .map(
          (entry) => `
            <article class="card">
              <p>${entry.text}</p>
              <p class="muted">${new Date(entry.createdAt).toLocaleString()}</p>
            </article>
          `
        )
        .join("")
    : `<div class="card muted">No recent activity.</div>`;
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  const worker = guardAuth(["worker"]);
  if (!worker) return;
  document.getElementById("welcomeWorker").textContent = worker.name;
  renderWorkerDashboard(worker.id);

  document.body.addEventListener("click", (event) => {
    const btn = event.target.closest("button[data-action]");
    if (!btn) return;
    const bookingId = btn.getAttribute("data-booking-id");
    const action = btn.getAttribute("data-action");
    if (!bookingId || !action) return;
    if (action === "accept") updateBookingStatus(bookingId, "accepted", worker.id);
    if (action === "reject") updateBookingStatus(bookingId, "rejected", worker.id);
    if (action === "complete") updateBookingStatus(bookingId, "completed", worker.id);
  });
});
