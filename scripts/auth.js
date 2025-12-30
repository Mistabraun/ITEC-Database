const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");

const email = document.getElementById("email");
const password = document.getElementById("password");
const verifyPassword = document.getElementById("verify-password");
const error = document.getElementById("error");
const signoutBtn = document.getElementById("signout");

// hard-coded user detail for testing demo purposes.
localStorage.setItem("user@mail.com", "user123");

const REGISTER_API = "api/register.php";
const LOGIN_API = "api/login.php";
const LOGOUT_API = "api/logout.php";
const SHOP_URL = "/shop.php";

function apiRequest(apiUrl, form = null, method = "POST") {
  let options = {
    method: method,
  };

  if (form) {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    options.body = JSON.stringify(data);
  }

  if (method == "POST") {
    options.headers = {
      "Content-Type": "application/json",
    };
  }

  return fetch(apiUrl, options)
    .then((response) => response.json())
    .catch((error) => {
      console.error("Error:", error);
      throw error;
    });
}

function defaultResponse(response) {
  password.value = "";
  if (!response.success) {
    onError(response.message);
    return;
  }

  window.location = SHOP_URL;
}

const onError = (message, form) => {
  email.focus();

  if (message) {
    error.innerText = message;
  }

  if (form) {
    form.reset();
  }
  error.style.display = "inline";
};

if (loginForm) {
  loginForm.addEventListener("submit", (event) => {
    event.preventDefault();

    let passwordValue = password.value;

    if (passwordValue.length <= 0) {
      onError("Invalid credentials");
      return;
    }

    apiRequest(LOGIN_API, event.target).then(defaultResponse);
  });
}

if (registerForm) {
  registerForm.addEventListener("submit", (event) => {
    event.preventDefault();

    let passwordValue = password.value;

    if (passwordValue !== verifyPassword.value) {
      onError("The password you’ve entered does not match.");
      return;
    } else if (passwordValue.length <= 0) {
      onError("The password must be at least 8 characters long.");
      return;
    }

    verifyPassword.value = "";
    apiRequest(REGISTER_API, event.target).then(defaultResponse);
  });
}

if (signoutBtn) {
  signoutBtn.addEventListener("click", (event) => {
    apiRequest(LOGOUT_API, null).then((resnpose) => {
      window.location = "/";
    });
  });
}
