function saveCards() {
  const allTabs = document.querySelectorAll(".tab-pane");
  const data = {};

  allTabs.forEach((tab) => {
    const tabId = tab.id;
    data[tabId] = [];
    tab.querySelectorAll(".cards .col").forEach((col) => {
      const title = col.querySelector(".card-title").textContent;
      const img = col.querySelector(".card-img-top").src;
      const bg = col.firstElementChild.style.backgroundColor || "";
      data[tabId].push({ title, img, bg });
    });
  });

  localStorage.setItem("cardsData", JSON.stringify(data));
}

function loadCards() {
  const data = JSON.parse(localStorage.getItem("cardsData"));
  if (!data) return;

  Object.keys(data).forEach((tabId) => {
    const tab = document.getElementById(tabId);
    const container = tab.querySelector(".cards");
    container.innerHTML = "";

    data[tabId].forEach((cardData) => {
      const template = document.getElementById("card");
      const $newCard = template.content.cloneNode(true);
      $newCard.querySelector(".card-title").textContent = cardData.title;
      $newCard.querySelector(".card-img-top").src = cardData.img;
      $newCard.querySelector(".card-img-top").alt = cardData.title;
      $newCard.firstElementChild.style.backgroundColor = cardData.bg;

      container.appendChild($newCard);
    });
  });
}

document.querySelectorAll(".cards").forEach((container) => {
  container.addEventListener("click", (e) => {
    if (e.target.classList.contains("delete-btn")) {
      const col = e.target.closest(".col");

      if (!document.startViewTransition) {
        col.remove();
        saveCards();
        return;
      }

      col.style.viewTransitionName = "targeted-card";
      document.startViewTransition(() => {
        col.remove();
        saveCards();
      });
    }
  });
});

document.querySelector(".add-btn").addEventListener("click", async () => {
  const template = document.getElementById("card");

  const movieTitle = prompt("Enter movie title:");
  if (!movieTitle) return;

  const movieUrl = prompt("Enter movie image URL:");
  if (!movieUrl) return;

  const $newCard = template.content.cloneNode(true);
  $newCard.querySelector(".card-title").textContent = movieTitle;
  $newCard.querySelector(".card-img-top").src = movieUrl;
  $newCard.querySelector(".card-img-top").alt = movieTitle;

  const activeCards = document.querySelector(".tab-pane.active .cards");

  if (!document.startViewTransition) {
    activeCards.appendChild($newCard);
    saveCards();
    return;
  }

  $newCard.firstElementChild.style.viewTransitionName = "targeted-card";
  $newCard.firstElementChild.style.backgroundColor = `#${Math.floor(
    Math.random() * 16777215
  ).toString(16)}`;

  const transition = document.startViewTransition(() => {
    activeCards.appendChild($newCard);
    saveCards();
  });

  await transition.finished;

  const rand =
    window.performance.now().toString().replace(".", "_") +
    Math.floor(Math.random() * 1000);
  activeCards.querySelector(
    ".card:last-child"
  ).style.viewTransitionName = `card-${rand}`;
});

window.addEventListener("DOMContentLoaded", loadCards);
