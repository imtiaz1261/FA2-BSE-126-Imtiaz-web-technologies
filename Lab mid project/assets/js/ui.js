function renderNav() {
  const currentUser = getCurrentUser();
  const authLinks = document.getElementById("authLinks");
  const userMenu = document.getElementById("userMenu");
  const userName = document.getElementById("userName");
  const dashboardLink = document.getElementById("dashboardLink");
  if (!authLinks || !userMenu) return;

  if (!currentUser) {
    authLinks.classList.remove("hidden");
    userMenu.classList.add("hidden");
    return;
  }

  authLinks.classList.add("hidden");
  userMenu.classList.remove("hidden");
  userName.textContent = currentUser.name;
  dashboardLink.href = currentUser.role === "worker" ? "dashboard-worker.html" : "dashboard-user.html";
}

function attachNavEvents() {
  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      clearCurrentUser();
      window.location.href = "index.html";
    });
  }
}

function guardAuth(allowedRoles) {
  const user = getCurrentUser();
  if (!user) {
    window.location.href = "login.html";
    return null;
  }
  if (allowedRoles && !allowedRoles.includes(user.role)) {
    window.location.href = user.role === "worker" ? "dashboard-worker.html" : "dashboard-user.html";
    return null;
  }
  return user;
}

function showMessage(targetId, text, type) {
  const box = document.getElementById(targetId);
  if (!box) return;
  box.innerHTML = `<div class="card" style="border-color:${type === "error" ? "#fecaca" : "#bbf7d0"}">${text}</div>`;
}

function stars(rating) {
  const full = Math.round(rating);
  return "★".repeat(full) + "☆".repeat(5 - full);
}
