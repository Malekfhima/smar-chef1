function affiche_pass() {
  var mot_de_passe = document.getElementById("password");
  var mot_de_passe2 = document.getElementById("confirm-password");
  var checked = document.getElementById("show-password").checked;
  if (checked) {
    mot_de_passe.type = "text";
    mot_de_passe2.type = "text";
  } else {
    mot_de_passe.type = "password";
    mot_de_passe2.type = "password";
  }
}

// Menu burger mobile universel
function toggleMenu() {
  const nav = document.getElementById("nav-menu");
  const btn = document.querySelector(".hamburger");
  const expanded = btn.getAttribute("aria-expanded") === "true";
  btn.setAttribute("aria-expanded", !expanded);
  nav.hidden = expanded;
  if (!expanded) {
    nav.classList.add("open");
    document.addEventListener("click", closeOnClickOutside);
  } else {
    nav.classList.remove("open");
    document.removeEventListener("click", closeOnClickOutside);
  }
  function closeOnClickOutside(e) {
    if (!nav.contains(e.target) && !btn.contains(e.target)) {
      btn.setAttribute("aria-expanded", "false");
      nav.hidden = true;
      nav.classList.remove("open");
      document.removeEventListener("click", closeOnClickOutside);
    }
  }
}
