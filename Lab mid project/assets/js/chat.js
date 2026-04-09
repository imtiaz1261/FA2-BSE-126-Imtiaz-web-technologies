function conversationId(userA, userB) {
  return [userA, userB].sort().join("_");
}

function renderMessages(convId, currentUser) {
  const box = document.getElementById("chatBox");
  const messages = getMessages().filter((item) => item.conversationId === convId);
  box.innerHTML = messages.map((item) => `
    <div class="bubble ${item.senderId === currentUser.id ? "me" : ""}">
      <div>${item.text}</div>
      <small class="muted">${new Date(item.createdAt).toLocaleString()}</small>
    </div>
  `).join("");
  box.scrollTop = box.scrollHeight;
}

document.addEventListener("DOMContentLoaded", () => {
  initData();
  renderNav();
  attachNavEvents();
  const currentUser = guardAuth(["user", "worker"]);
  if (!currentUser) return;

  const params = new URLSearchParams(window.location.search);
  let peerId = params.get("workerId");
  if (currentUser.role === "worker") {
    peerId = params.get("userId");
  }

  if (!peerId) {
    const relatedBooking = getBookings().find((booking) => currentUser.role === "user" ? booking.userId === currentUser.id : booking.workerId === currentUser.id);
    peerId = relatedBooking ? (currentUser.role === "user" ? relatedBooking.workerId : relatedBooking.userId) : null;
  }

  if (!peerId) {
    showMessage("chatMessage", "No conversation available yet. Create a booking first.", "error");
    return;
  }

  const peer = getUsers().find((user) => user.id === peerId);
  document.getElementById("chatWith").textContent = peer ? peer.name : "Conversation";
  const convId = conversationId(currentUser.id, peerId);
  renderMessages(convId, currentUser);

  document.getElementById("chatForm").addEventListener("submit", (event) => {
    event.preventDefault();
    const input = document.getElementById("messageInput");
    const text = input.value.trim();
    if (!text) return;
    const messages = getMessages();
    messages.push({
      id: uid("m"),
      conversationId: convId,
      senderId: currentUser.id,
      receiverId: peerId,
      text,
      createdAt: new Date().toISOString()
    });
    saveMessages(messages);
    input.value = "";
    renderMessages(convId, currentUser);
  });
});
