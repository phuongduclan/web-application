function openSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (sidebar && overlay) {
    sidebar.classList.add("active");
    overlay.classList.add("active");
  }
}

function closeSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (sidebar && overlay) {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
  }
}

const loginForm = document.getElementById("loginForm");

if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const loginMessage = document.getElementById("loginMessage");

    if (email === "" || password === "") {
      loginMessage.style.color = "red";
      loginMessage.textContent = "Please enter full email and password.";
      return;
    }

    if (email === "user@gmail.com" && password === "123456") {
      loginMessage.style.color = "green";
      loginMessage.textContent = "Login successful!";

      localStorage.setItem("isLoggedIn", "true");
      localStorage.setItem("userEmail", email);

      setTimeout(() => {
        window.location.href = "../../index.html";
      }, 1000);
    } else {
      loginMessage.style.color = "red";
      loginMessage.textContent = "Incorrect email or password.";
    }
  });
}
