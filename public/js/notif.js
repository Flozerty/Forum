const notifs = document.querySelectorAll(".message")

notifs.forEach(notif => {
  if (!notif.innerHTML) {
    notif.style.display = "none";
  }
})