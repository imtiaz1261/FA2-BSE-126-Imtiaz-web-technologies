function getServices() {
    return JSON.parse(localStorage.getItem("sls_services")) || [];
}

function saveServices(services) {
    localStorage.setItem("sls_services", JSON.stringify(services));
}

function setAdminMessage(type, text) {
    const box = document.getElementById("adminMessage");
    if (!box) {
        return;
    }
    box.innerHTML = `<div class="notice notice-${type}">${text}</div>`;
}

function applyTheme() {
    const isDark = localStorage.getItem("sls_theme") === "dark";
    document.body.classList.toggle("dark-mode", isDark);
}

function ensureAdminAccess() {
    const currentUser = localStorage.getItem("sls_current_user");
    const currentRole = localStorage.getItem("sls_current_role");
    const isAdmin = currentUser === "admin@sls.com" && currentRole === "admin";
    if (!isAdmin) {
        alert("Access denied. Admin login required.");
        window.location.href = "login.html";
        return false;
    }
    return true;
}

function renderAdminServices() {
    const list = document.getElementById("adminServiceList");
    if (!list) {
        return;
    }
    const services = getServices();
    if (!services.length) {
        list.innerHTML = `<div class="notice notice-info">No services available.</div>`;
        return;
    }

    list.innerHTML = services.map((service) => `
        <article class="admin-service-item">
            <div>
                <h4>${service.name}</h4>
                <p>${service.desc}</p>
            </div>
            <button class="btn danger" onclick="deleteService('${service.id}')">Delete</button>
        </article>
    `).join("");
}

function addService(event) {
    event.preventDefault();
    const name = document.getElementById("name").value.trim();
    const desc = document.getElementById("desc").value.trim();

    if (!name || !desc) {
        setAdminMessage("danger", "Please fill both fields.");
        return;
    }

    const services = getServices();
    const duplicate = services.some((service) => service.name.toLowerCase() === name.toLowerCase());
    if (duplicate) {
        setAdminMessage("warning", "Service with this name already exists.");
        return;
    }

    services.push({
        id: String(Date.now()),
        name,
        desc
    });
    saveServices(services);
    document.getElementById("serviceForm").reset();
    setAdminMessage("success", "Service added successfully.");
    renderAdminServices();
}

function deleteService(id) {
    const services = getServices().filter((service) => service.id !== id);
    saveServices(services);
    renderAdminServices();
    setAdminMessage("success", "Service deleted.");
}

const serviceForm = document.getElementById("serviceForm");
if (serviceForm) {
    serviceForm.addEventListener("submit", addService);
}

if (ensureAdminAccess()) {
    renderAdminServices();
    applyTheme();
}