function renderWorkerProfile() {
  const params = new URLSearchParams(window.location.search);
  const workerId = params.get("workerId") || "w1";
  const worker = getWorkerById(workerId);
  const services = getServices().filter((service) => service.workerId === workerId);
  const box = document.getElementById("workerCard");
  if (!worker) {
    box.innerHTML = `<div class="card">Worker not found.</div>`;
    return;
  }
  box.innerHTML = `
    <article class="card">
      <div class="section-title">
        <h2>${worker.name}</h2>
        <span class="badge">${worker.category}</span>
      </div>
      <p class="muted">${worker.bio}</p>
      <p>${worker.experience} years experience · $${worker.hourlyRate}/hour · <span class="rating">${stars(worker.rating)}</span></p>
      <p class="muted">Address: ${worker.address || "Address not provided"}</p>
      <h3 class="mt-2">Portfolio</h3>
      <div class="portfolio mt-1">${worker.portfolio.map((item) => `<div>${item}</div>`).join("")}</div>
      <h3 class="mt-2">Services</h3>
      <div class="list">${services.map((service) => `<div class="card"><strong>${service.title}</strong><p class="muted">${service.description}</p><a class="btn primary" href="booking.html?serviceId=${service.id}">Book This</a></div>`).join("")}</div>
    </article>
  `;
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  renderWorkerProfile();
});
