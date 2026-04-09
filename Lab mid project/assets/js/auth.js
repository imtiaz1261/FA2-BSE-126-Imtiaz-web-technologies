document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();

  const signupForm = document.getElementById("signupForm");
  const loginForm = document.getElementById("loginForm");
  const roleSelect = document.getElementById("role");
  const workerFields = document.getElementById("workerFields");

  if (roleSelect && workerFields) {
    const toggleWorkerFields = () => {
      const isWorker = roleSelect.value === "worker";
      workerFields.classList.toggle("hidden", !isWorker);
    };
    roleSelect.addEventListener("change", toggleWorkerFields);
    toggleWorkerFields();
  }

  if (signupForm) {
    signupForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim().toLowerCase();
      const password = document.getElementById("password").value.trim();
      const role = document.getElementById("role").value;
      const users = getUsers();
      if (users.some((user) => user.email === email)) {
        showMessage("authMessage", "Email already registered.", "error");
        return;
      }

      let newUser;
      if (role === "worker") {
        const category = document.getElementById("workerCategory").value;
        const experience = Number(document.getElementById("workerExperience").value || 0);
        const hourlyRate = Number(document.getElementById("workerRate").value || 0);
        const address = document.getElementById("workerAddress").value.trim();
        const bio = document.getElementById("workerBio").value.trim();
        if (!address) {
          showMessage("authMessage", "Worker ke liye full address required hai.", "error");
          return;
        }
        const location = await geocodeAddress(address);
        newUser = {
          id: uid("w"),
          role,
          name,
          email,
          password,
          category,
          experience,
          hourlyRate,
          address,
          location,
          rating: 4.5,
          bio: bio || `${category} specialist available for local services.`,
          portfolio: ["Recent Project 1", "Recent Project 2", "Recent Project 3"]
        };
      } else {
        newUser = {
          id: uid("u"),
          role,
          name,
          email,
          password
        };
      }

      users.push(newUser);
      saveUsers(users);

      if (role === "worker") {
        const services = getServices();
        services.push({
          id: uid("s"),
          title: `${newUser.category} Home Service`,
          category: newUser.category,
          workerId: newUser.id,
          price: Math.max(newUser.hourlyRate, 10),
          rating: newUser.rating,
          description: `${newUser.name} offering ${newUser.category.toLowerCase()} services near ${newUser.address}.`
        });
        saveServices(services);
      }

      setCurrentUser(newUser);
      window.location.href = role === "worker" ? "dashboard-worker.html" : "dashboard-user.html";
    });
  }

  if (loginForm) {
    loginForm.addEventListener("submit", (event) => {
      event.preventDefault();
      const email = document.getElementById("email").value.trim().toLowerCase();
      const password = document.getElementById("password").value.trim();
      const user = getUsers().find((entry) => entry.email === email && entry.password === password);
      if (!user) {
        showMessage("authMessage", "Invalid email or password.", "error");
        return;
      }
      setCurrentUser(user);
      window.location.href = user.role === "worker" ? "dashboard-worker.html" : "dashboard-user.html";
    });
  }
});
