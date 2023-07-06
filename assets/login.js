const currentToken = localStorage.getItem("token");
if (currentToken) {
  window.location.replace("/dashboard");
}

document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("#login-form");



  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;

    const request = fetch("/api/login_check", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username: email, password: password }),
    });

    request
      .then((response) => {
        const errorMessage = document.querySelector("#error-message");
        if (response.status === 200) {
          response.json().then((data) => {
            localStorage.setItem("token", data.token);
            errorMessage.classList.add("hidden");
            window.location.replace("/dashboard");
          });
        } else {
          errorMessage.classList.remove("hidden");
          errorMessage.innerHTML = "Adresse email ou mot de passe incorrect";
        }
      })
      .catch((error) => {
        console.log(error);
      });
  });
});
