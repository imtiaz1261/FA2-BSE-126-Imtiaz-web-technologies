function addressScore(workerAddress, customerAddress) {
  if (!workerAddress || !customerAddress) return 0;
  const normalize = (value) => value.toLowerCase().replace(/[^a-z0-9\s]/g, " ");
  const workerTokens = normalize(workerAddress).split(/\s+/).filter((token) => token.length > 2);
  const customerTokens = normalize(customerAddress).split(/\s+/).filter((token) => token.length > 2);
  const customerSet = new Set(customerTokens);
  let score = 0;
  workerTokens.forEach((token) => {
    if (customerSet.has(token)) score += 1;
  });
  if (normalize(workerAddress).includes(normalize(customerAddress)) || normalize(customerAddress).includes(normalize(workerAddress))) {
    score += 3;
  }
  return score;
}

async function filteredServices() {
  const query = document.getElementById("search").value.trim().toLowerCase();
  const category = document.getElementById("category").value;
  const minRating = Number(document.getElementById("minRating").value || 0);
  const customerAddress = document.getElementById("customerAddress").value.trim();

  const filtered = getServices().filter((service) => {
    const textMatch = `${service.title} ${service.description}`.toLowerCase().includes(query);
    const catMatch = !category || service.category === category;
    const rateMatch = service.rating >= minRating;
    return textMatch && catMatch && rateMatch;
  });

  const ranked = filtered.map((service) => {
    const worker = getWorkerById(service.workerId);
    return {
      service,
      worker,
      nearScore: addressScore(worker ? worker.address : "", customerAddress),
      distance: Number.POSITIVE_INFINITY
    };
  });

  if (customerAddress && category) {
    const customerLocation = await geocodeAddress(customerAddress);
    if (customerLocation) {
      ranked.forEach((item) => {
        const workerLocation = item.worker && item.worker.location ? item.worker.location : null;
        item.distance = workerLocation ? distanceKm(customerLocation, workerLocation) : Number.POSITIVE_INFINITY;
      });
      ranked.sort((a, b) => a.distance - b.distance || b.service.rating - a.service.rating);
      return ranked;
    }

    const nearby = ranked.filter((item) => item.nearScore > 0);
    const base = nearby.length ? nearby : ranked;
    base.sort((a, b) => b.nearScore - a.nearScore || b.service.rating - a.service.rating);
    return base;
  }
  return ranked;
}

async function renderServices() {
  const list = document.getElementById("serviceList");
  const count = document.getElementById("resultCount");
  const services = await filteredServices();
  list.innerHTML = services.map(({ service, worker, nearScore, distance }) => {
    const locationText = Number.isFinite(distance)
      ? ` · Distance: ${distance.toFixed(1)} km`
      : (nearScore > 0 ? ` · Nearby match: ${nearScore}` : "");
    return `
      <article class="card">
        <div class="section-title">
          <span class="badge">${service.category}</span>
          <span class="muted">$${service.price}</span>
        </div>
        <h3>${service.title}</h3>
        <p class="muted">${service.description}</p>
        <p>${worker ? worker.name : "Unknown"} · <span class="rating">${stars(service.rating)}</span></p>
        <p class="muted">${worker && worker.address ? worker.address : "Address not available"}${locationText}</p>
        <div class="row-2">
          <a class="btn" href="worker-profile.html?workerId=${service.workerId}">Worker Profile</a>
          <a class="btn primary" href="booking.html?serviceId=${service.id}">Book</a>
        </div>
      </article>
    `;
  }).join("");
  count.textContent = `${services.length} services found`;
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  const params = new URLSearchParams(window.location.search);
  const categories = [...new Set(getServices().map((service) => service.category))];
  document.getElementById("category").innerHTML = `<option value="">All categories</option>${categories.map((item) => `<option value="${item}">${item}</option>`).join("")}`;
  const categoryFromQuery = params.get("category");
  const searchFromQuery = params.get("q");
  if (categoryFromQuery && categories.includes(categoryFromQuery)) {
    document.getElementById("category").value = categoryFromQuery;
  }
  if (searchFromQuery) {
    document.getElementById("search").value = searchFromQuery;
  }
  ["search", "category", "minRating", "customerAddress"].forEach((id) => {
    document.getElementById(id).addEventListener("input", renderServices);
  });
  renderServices();
});
