function renderUserBookings(user) {
  const list = document.getElementById("bookingList");
  const rows = getBookings().filter((booking) => booking.userId === user.id);
  list.innerHTML = rows.length ? rows.map((booking) => {
    const service = getServiceById(booking.serviceId);
    const worker = getWorkerById(booking.workerId);
    return `
      <article class="card">
        <div class="section-title">
          <strong>${service ? service.title : "Service"}</strong>
          <span class="status-pill status-${booking.status}">${booking.status}</span>
        </div>
        <p class="muted">${booking.date} at ${booking.time} · ${worker ? worker.name : "Worker"}</p>
        <p class="muted">Address: ${booking.customerAddress || "Not provided"}</p>
        <div class="row-2 mt-1">
          <button
            class="btn"
            ${booking.status === "cancelled" || booking.status === "completed" ? "disabled" : ""}
            data-action="reschedule"
            data-booking-id="${booking.id}"
          >Reschedule</button>
          <button
            class="btn danger"
            ${booking.status === "cancelled" || booking.status === "completed" ? "disabled" : ""}
            data-action="cancel"
            data-booking-id="${booking.id}"
          >Cancel</button>
        </div>
      </article>
    `;
  }).join("") : `<div class="card muted">No bookings yet.</div>`;
}

function cancelBooking(bookingId, userId) {
  const bookings = getBookings();
  const index = bookings.findIndex((booking) => booking.id === bookingId && booking.userId === userId);
  if (index < 0) return;
  bookings[index].status = "cancelled";
  bookings[index].updatedAt = new Date().toISOString();
  saveBookings(bookings);
  const user = getUsers().find((entry) => entry.id === userId);
  if (user) {
    showMessage("bookingMessage", "Booking cancelled successfully.", "success");
    renderUserBookings(user);
  }
}

function updateBookingSchedule(bookingId, userId, newDate, newTime) {
  const bookings = getBookings();
  const index = bookings.findIndex((booking) => booking.id === bookingId && booking.userId === userId);
  if (index < 0) return;

  if (bookings[index].status === "cancelled" || bookings[index].status === "completed") return;

  bookings[index].date = newDate.trim();
  bookings[index].time = newTime.trim();
  bookings[index].status = "pending";
  bookings[index].updatedAt = new Date().toISOString();
  saveBookings(bookings);
  const user = getUsers().find((entry) => entry.id === userId);
  if (user) {
    showMessage("bookingMessage", "Booking rescheduled successfully.", "success");
    renderUserBookings(user);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  const user = guardAuth(["user"]);
  if (!user) return;

  const overlay = document.getElementById("rescheduleModalOverlay");
  const hint = document.getElementById("rescheduleModalHint");
  const dateInput = document.getElementById("rescheduleDate");
  const timeInput = document.getElementById("rescheduleTime");
  const confirmBtn = document.getElementById("confirmRescheduleBtn");
  const closeBtn = document.getElementById("closeRescheduleBtn");
  const cancelBtn = document.getElementById("cancelRescheduleBtn");

  let activeRescheduleBookingId = null;

  function openRescheduleModal(bookingId) {
    const bookings = getBookings();
    const booking = bookings.find((b) => b.id === bookingId && b.userId === user.id);
    if (!booking) return;
    if (booking.status === "cancelled" || booking.status === "completed") return;

    activeRescheduleBookingId = bookingId;
    if (hint) hint.textContent = `Update schedule for: ${booking.date} at ${booking.time}`;
    if (dateInput) dateInput.value = booking.date || "";
    if (timeInput) timeInput.value = booking.time || "";
    if (overlay) overlay.classList.remove("hidden");
  }

  function closeRescheduleModal() {
    activeRescheduleBookingId = null;
    if (overlay) overlay.classList.add("hidden");
  }

  if (overlay) {
    overlay.addEventListener("click", (event) => {
      if (event.target === overlay) closeRescheduleModal();
    });
  }
  if (confirmBtn) {
    confirmBtn.addEventListener("click", () => {
      const newDate = dateInput.value;
      const newTime = timeInput.value;
      if (!newDate || !newTime) {
        showMessage("bookingMessage", "Please select date and time.", "error");
        return;
      }
      updateBookingSchedule(activeRescheduleBookingId, user.id, newDate, newTime);
      closeRescheduleModal();
    });
  }
  if (closeBtn) closeBtn.addEventListener("click", closeRescheduleModal);
  if (cancelBtn) cancelBtn.addEventListener("click", closeRescheduleModal);

  const params = new URLSearchParams(window.location.search);
  const serviceId = params.get("serviceId");
  const service = getServiceById(serviceId) || getServices()[0];
  document.getElementById("serviceInfo").textContent = service ? `${service.title} (${service.category})` : "No service selected";

  document.getElementById("bookingForm").addEventListener("submit", (event) => {
    event.preventDefault();
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const notes = document.getElementById("notes").value.trim();
    const customerAddress = document.getElementById("customerAddress").value.trim();
    if (!date || !time || !service || !customerAddress) {
      showMessage("bookingMessage", "Please pick service, date, time and full address.", "error");
      return;
    }
    const bookings = getBookings();
    bookings.push({
      id: uid("b"),
      userId: user.id,
      workerId: service.workerId,
      serviceId: service.id,
      date,
      time,
      notes,
      customerAddress,
      status: "pending",
      createdAt: new Date().toISOString()
    });
    saveBookings(bookings);
    showMessage("bookingMessage", "Booking created successfully.", "success");
    event.target.reset();
    renderUserBookings(user);
  });

  const bookingList = document.getElementById("bookingList");
  bookingList.addEventListener("click", (event) => {
    const btn = event.target.closest("button[data-action]");
    if (!btn) return;
    const bookingId = btn.getAttribute("data-booking-id");
    const action = btn.getAttribute("data-action");
    if (!bookingId || !action) return;
    if (action === "cancel") cancelBooking(bookingId, user.id);
    if (action === "reschedule") openRescheduleModal(bookingId);
  });

  renderUserBookings(user);
});
