function renderDashboardUser(user) {
  const list = document.getElementById("dashboardBookings");
  const bookings = getBookings().filter((booking) => booking.userId === user.id);
  list.innerHTML = bookings.length ? bookings.map((booking) => {
    const service = getServiceById(booking.serviceId);
    const worker = getWorkerById(booking.workerId);
    return `
      <article class="card">
        <div class="section-title">
          <strong>${service ? service.title : "Service"}</strong>
          <span class="status-pill status-${booking.status}">${booking.status}</span>
        </div>
        <p class="muted">${booking.date} ${booking.time} · Worker: ${worker ? worker.name : "Unknown"}</p>
        <div class="row-2 mt-1">
          <a class="btn" href="worker-profile.html?workerId=${booking.workerId}">View Worker</a>
          <a class="btn primary" href="chat.html?workerId=${booking.workerId}">Chat</a>
        </div>
        <div class="row-2 mt-1">
          <button
            class="btn"
            ${booking.status === "cancelled" ? "disabled" : ""}
            data-action="reschedule"
            data-booking-id="${booking.id}"
          >Reschedule</button>
          <button
            class="btn danger"
            ${booking.status === "cancelled" ? "disabled" : ""}
            data-action="cancel"
            data-booking-id="${booking.id}"
          >Cancel</button>
        </div>
      </article>
    `;
  }).join("") : `<div class="card muted">No bookings found.</div>`;
}

function cancelBookingFromDashboard(bookingId, userId) {
  const bookings = getBookings();
  const index = bookings.findIndex((booking) => booking.id === bookingId && booking.userId === userId);
  if (index < 0) return;
  bookings[index].status = "cancelled";
  bookings[index].updatedAt = new Date().toISOString();
  saveBookings(bookings);
  const user = getUsers().find((entry) => entry.id === userId);
  if (user) renderDashboardUser(user);
}

function rescheduleBookingFromDashboard(bookingId, userId) {
  const bookings = getBookings();
  const index = bookings.findIndex((booking) => booking.id === bookingId && booking.userId === userId);
  if (index < 0) return;
  if (bookings[index].status === "cancelled") return;
  const nextDate = window.prompt("New date (YYYY-MM-DD):", bookings[index].date || "");
  if (!nextDate) return;
  const nextTime = window.prompt("New time (HH:MM):", bookings[index].time || "");
  if (!nextTime) return;
  bookings[index].date = nextDate.trim();
  bookings[index].time = nextTime.trim();
  bookings[index].status = "pending";
  bookings[index].updatedAt = new Date().toISOString();
  saveBookings(bookings);
  const user = getUsers().find((entry) => entry.id === userId);
  if (user) renderDashboardUser(user);
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  const user = guardAuth(["user"]);
  if (!user) return;
  document.getElementById("welcome").textContent = user.name;
  renderDashboardUser(user);

  const container = document.getElementById("dashboardBookings");
  container.addEventListener("click", (event) => {
    const btn = event.target.closest("button[data-action]");
    if (!btn) return;
    const bookingId = btn.getAttribute("data-booking-id");
    const action = btn.getAttribute("data-action");
    if (!bookingId || !action) return;
    if (action === "cancel") cancelBookingFromDashboard(bookingId, user.id);
    if (action === "reschedule") rescheduleBookingFromDashboard(bookingId, user.id);
  });
});
