function renderFeaturedServices() {
  const list = document.getElementById("serviceCards");
  const services = getServices().slice(0, 6);

  const getCategoryImage = (category) => {
    const imageByCategory = {
      Electrician: "electrition.jfif",
      Plumber: "download.jfif",
      Tutor: "tutor.jfif",
      Cleaner: "cleaning.jfif"
    };
    return imageByCategory[category] || "download.jfif";
  };

  list.innerHTML = services.map((service) => {
    const worker = getWorkerById(service.workerId);
    return `
      <article class="card">
        <img class="service-thumb" src="${getCategoryImage(service.category)}" alt="${service.category} service" loading="lazy">
        <span class="badge">${service.category}</span>
        <h3>${service.title}</h3>
        <p class="muted">${service.description}</p>
        <p><strong>$${service.price}</strong>/job · ${worker ? worker.name : "Worker"} · <span class="rating">${stars(service.rating)}</span></p>
        <a class="btn primary" href="worker-profile.html?workerId=${service.workerId}">View Worker</a>
      </article>
    `;
  }).join("");
}

function renderHomeCategories() {
  const list = document.getElementById("homeCategoryGrid");
  if (!list) return;

  const icons = {
    Electrician: "⚡",
    Plumber: "🔧",
    Tutor: "📘",
    Cleaner: "🧹",
    Beautician: "💄",
    Carpenter: "🪚"
  };

  const categories = [...new Set(getServices().map((service) => service.category))].slice(0, 8);
  list.innerHTML = categories
    .map(
      (category) => `
        <a class="home-category-card" href="services.html?category=${encodeURIComponent(category)}">
          <span class="home-category-icon">${icons[category] || "🛠"}</span>
          <h3>${category}</h3>
        </a>
      `
    )
    .join("");
}

function attachDrawerEvents() {
  const drawer = document.getElementById("sidebarDrawer");
  const backdrop = document.getElementById("drawerBackdrop");
  const openBtn = document.getElementById("openDrawerBtn");
  const closeBtn = document.getElementById("closeDrawerBtn");
  if (!drawer || !backdrop || !openBtn || !closeBtn) return;

  const closeDrawer = () => {
    drawer.classList.remove("open");
    backdrop.classList.remove("show");
    drawer.setAttribute("aria-hidden", "true");
  };

  const openDrawer = () => {
    drawer.classList.add("open");
    backdrop.classList.add("show");
    drawer.setAttribute("aria-hidden", "false");
  };

  openBtn.addEventListener("click", openDrawer);
  closeBtn.addEventListener("click", closeDrawer);
  backdrop.addEventListener("click", closeDrawer);

  drawer.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeDrawer);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeDrawer();
  });
}

function renderWorkersByCategory() {
  const box = document.getElementById("workerCategorySections");
  if (!box) return;

  const workers = getUsers().filter((user) => user.role === "worker");
  const grouped = workers.reduce((acc, worker) => {
    const key = worker.category || "Other";
    if (!acc[key]) acc[key] = [];
    acc[key].push(worker);
    return acc;
  }, {});

  box.innerHTML = Object.keys(grouped)
    .sort()
    .map((category) => {
      const cards = grouped[category]
        .map(
          (worker) => `
            <article class="card">
              <div class="section-title">
                <strong>${worker.name}</strong>
                <span class="badge">${category}</span>
              </div>
              <p class="muted">${worker.bio || "Trusted local professional"}</p>
              <p>${worker.experience || 0} yrs · $${worker.hourlyRate || 0}/hr · <span class="rating">${stars(worker.rating || 4.5)}</span></p>
              <div class="worker-preview mb-1">
                ${(worker.portfolio || []).slice(0, 3).map((item) => `<span>• ${item}</span>`).join("")}
              </div>
              <a class="btn primary" href="worker-profile.html?workerId=${worker.id}">View Profile</a>
            </article>
          `
        )
        .join("");
      return `
        <section class="category-section">
          <div class="category-header">
            <h3>${category}</h3>
            <span class="muted">${grouped[category].length} worker(s)</span>
          </div>
          <div class="grid cards">${cards}</div>
        </section>
      `;
    })
    .join("");
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  attachDrawerEvents();
  renderHomeCategories();
  renderFeaturedServices();
  renderWorkersByCategory();
});
