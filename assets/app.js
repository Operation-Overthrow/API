document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelector("#logout-button");

    if(logoutButton) {
        logoutButton.addEventListener("click", (e) => {
            e.preventDefault();
            localStorage.removeItem("token");
    
            window.location.replace("/dashboard/login");
        });
    }
});