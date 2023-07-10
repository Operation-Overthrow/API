document.addEventListener("DOMContentLoaded", function () {
  const token = localStorage.getItem("token");

  if (!token) {
    window.location.replace("/dashboard/login");
  }

  const request = fetch("/api/games", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  });

  request
    .then((response) => {
      if (response.status === 200) {
        const gamesList = document.querySelector("#games-list");
        response.json().then((data) => {
          if (data.length !== 0) {
            gamesList.innerHTML = "";
            data.forEach((game) => {
              const gameRow = document.createElement("tr");
              const gameId = document.createElement("th");
              const gameDate = document.createElement("td");
              const gameScore = document.createElement("td");

              gameId.setAttribute("scope", "row");

              gameId.innerHTML = game.id;
              gameDate.innerHTML = "TODO";
              gameScore.innerHTML = game.score;

              gameRow.appendChild(gameId);
              gameRow.appendChild(gameDate);
              gameRow.appendChild(gameScore);

              gamesList.appendChild(gameRow);
            });
          }
        });
      } else {
        localStorage.removeItem("token");
        window.location.replace("/dashboard/login");
      }
    })
    .catch((error) => {
      console.log(error);
      localStorage.removeItem("token");
      window.location.replace("/dashboard/login");
    });
});
