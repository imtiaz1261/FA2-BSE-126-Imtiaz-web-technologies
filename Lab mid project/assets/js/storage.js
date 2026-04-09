const APP_KEYS = {
  USERS: "sls_users_v2",
  CURRENT_USER: "sls_current_user_v2",
  SERVICES: "sls_services_v2",
  BOOKINGS: "sls_bookings_v2",
  MESSAGES: "sls_messages_v2",
  ACTIVITY: "sls_worker_activity_v1"
};

const seedWorkers = [
  {
    id: "w1",
    role: "worker",
    name: "Ali Raza",
    email: "ali@workers.com",
    password: "123456",
    category: "Electrician",
    experience: 6,
    rating: 4.8,
    hourlyRate: 18,
    address: "Block A, Gulshan-e-Iqbal, Karachi",
    location: { lat: 24.9223, lng: 67.0909 },
    bio: "Certified electrician specializing in home wiring and emergency fixes.",
    portfolio: ["Wiring Upgrade", "Panel Setup", "Smart Switch Install"]
  },
  {
    id: "w2",
    role: "worker",
    name: "Sara Khan",
    email: "sara@workers.com",
    password: "123456",
    category: "Plumber",
    experience: 5,
    rating: 4.6,
    hourlyRate: 16,
    address: "Street 12, North Nazimabad, Karachi",
    location: { lat: 24.9272, lng: 67.0417 },
    bio: "Fast and neat plumbing service with leak detection expertise.",
    portfolio: ["Kitchen Pipeline", "Bathroom Fitting", "Leak Repair"]
  },
  {
    id: "w3",
    role: "worker",
    name: "Hassan Noor",
    email: "hassan@workers.com",
    password: "123456",
    category: "Tutor",
    experience: 4,
    rating: 4.9,
    hourlyRate: 20,
    address: "Model Town, Lahore",
    location: { lat: 31.4834, lng: 74.3276 },
    bio: "Math and science tutor helping students improve grades confidently.",
    portfolio: ["Grade 10 Coaching", "Physics Prep", "Exam Strategy"]
  },
  {
    id: "w4",
    role: "worker",
    name: "Areeba Malik",
    email: "areeba@workers.com",
    password: "123456",
    category: "Cleaner",
    experience: 3,
    rating: 4.7,
    hourlyRate: 14,
    address: "Johar Town, Lahore",
    location: { lat: 31.4697, lng: 74.2728 },
    bio: "Reliable home and office cleaning with quality supplies.",
    portfolio: ["Kitchen Deep Clean", "Sofa Cleaning", "Office Sanitization"]
  }
];

const seedUsers = [
  { id: "u1", role: "user", name: "Demo User", email: "user@demo.com", password: "123456" },
  ...seedWorkers
];

const seedServices = [
  { id: "s1", title: "Home Electrical Repair", category: "Electrician", workerId: "w1", price: 30, rating: 4.8, description: "Switches, sockets, lights and minor rewiring." },
  { id: "s2", title: "Ceiling Fan Installation", category: "Electrician", workerId: "w1", price: 25, rating: 4.7, description: "Safe fan installation with balancing." },
  { id: "s3", title: "Bathroom Plumbing Fix", category: "Plumber", workerId: "w2", price: 28, rating: 4.6, description: "Leak repairs, faucet and pipe maintenance." },
  { id: "s4", title: "Kitchen Sink Maintenance", category: "Plumber", workerId: "w2", price: 22, rating: 4.5, description: "Drain cleaning and sink pipeline adjustments." },
  { id: "s5", title: "Math Home Tutoring", category: "Tutor", workerId: "w3", price: 24, rating: 4.9, description: "One-on-one grade improvement sessions." },
  { id: "s6", title: "Physics Exam Prep", category: "Tutor", workerId: "w3", price: 26, rating: 4.8, description: "Targeted concept building and practice plans." },
  { id: "s7", title: "Home Deep Cleaning", category: "Cleaner", workerId: "w4", price: 20, rating: 4.7, description: "Room-by-room deep cleaning and sanitation." }
];

const seedBookings = [
  {
    id: "b_seed_1",
    userId: "u1",
    workerId: "w1",
    serviceId: "s1",
    date: "2026-04-03",
    time: "10:00",
    notes: "Need urgent socket check",
    customerAddress: "Gulshan-e-Iqbal, Karachi",
    status: "pending",
    createdAt: new Date().toISOString()
  },
  {
    id: "b_seed_2",
    userId: "u1",
    workerId: "w2",
    serviceId: "s3",
    date: "2026-03-28",
    time: "12:30",
    notes: "Bathroom leakage",
    customerAddress: "North Nazimabad, Karachi",
    status: "completed",
    rating: 4.6,
    review: "Quick visit and clean work.",
    createdAt: new Date().toISOString()
  },
  {
    id: "b_seed_3",
    userId: "u1",
    workerId: "w1",
    serviceId: "s2",
    date: "2026-03-30",
    time: "15:00",
    notes: "Fan installation",
    customerAddress: "PECHS, Karachi",
    status: "accepted",
    createdAt: new Date().toISOString()
  }
];

function read(key, fallback) {
  const value = localStorage.getItem(key);
  return value ? JSON.parse(value) : fallback;
}

function write(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function initData() {
  if (!localStorage.getItem(APP_KEYS.USERS)) {
    write(APP_KEYS.USERS, seedUsers);
  }
  if (!localStorage.getItem(APP_KEYS.SERVICES)) {
    write(APP_KEYS.SERVICES, seedServices);
  }
  if (!localStorage.getItem(APP_KEYS.BOOKINGS)) {
    write(APP_KEYS.BOOKINGS, seedBookings);
  }
  if (!localStorage.getItem(APP_KEYS.MESSAGES)) {
    write(APP_KEYS.MESSAGES, []);
  }
  if (!localStorage.getItem(APP_KEYS.ACTIVITY)) {
    write(APP_KEYS.ACTIVITY, []);
  }

  // Lightweight migration for existing seeded workers created before location support.
  const users = getUsers();
  let changed = false;
  const withLocation = users.map((user) => {
    if (user.role !== "worker" || user.location) return user;
    if (!user.address) return user;
    const normalized = user.address.toLowerCase();
    if (normalized.includes("gulshan") && normalized.includes("karachi")) {
      changed = true;
      return { ...user, location: { lat: 24.9223, lng: 67.0909 } };
    }
    if (normalized.includes("nazimabad") && normalized.includes("karachi")) {
      changed = true;
      return { ...user, location: { lat: 24.9272, lng: 67.0417 } };
    }
    if (normalized.includes("model town") && normalized.includes("lahore")) {
      changed = true;
      return { ...user, location: { lat: 31.4834, lng: 74.3276 } };
    }
    return user;
  });
  if (changed) saveUsers(withLocation);
}

function getUsers() {
  return read(APP_KEYS.USERS, []);
}

function saveUsers(users) {
  write(APP_KEYS.USERS, users);
}

function getCurrentUser() {
  return read(APP_KEYS.CURRENT_USER, null);
}

function setCurrentUser(user) {
  write(APP_KEYS.CURRENT_USER, user);
}

function clearCurrentUser() {
  localStorage.removeItem(APP_KEYS.CURRENT_USER);
}

function getServices() {
  return read(APP_KEYS.SERVICES, []);
}

function getServiceById(serviceId) {
  return getServices().find((service) => service.id === serviceId);
}

function saveServices(services) {
  write(APP_KEYS.SERVICES, services);
}

function getWorkerById(workerId) {
  return getUsers().find((user) => user.id === workerId && user.role === "worker");
}

function getUserById(userId) {
  return getUsers().find((user) => user.id === userId);
}

function getBookings() {
  return read(APP_KEYS.BOOKINGS, []);
}

function saveBookings(bookings) {
  write(APP_KEYS.BOOKINGS, bookings);
}

function getMessages() {
  return read(APP_KEYS.MESSAGES, []);
}

function saveMessages(messages) {
  write(APP_KEYS.MESSAGES, messages);
}

function getWorkerActivity() {
  return read(APP_KEYS.ACTIVITY, []);
}

function saveWorkerActivity(logs) {
  write(APP_KEYS.ACTIVITY, logs);
}

function logWorkerActivity(workerId, text) {
  const logs = getWorkerActivity();
  logs.unshift({
    id: uid("a"),
    workerId,
    text,
    createdAt: new Date().toISOString()
  });
  saveWorkerActivity(logs.slice(0, 100));
}

function uid(prefix) {
  return `${prefix}_${Date.now()}_${Math.floor(Math.random() * 9999)}`;
}
