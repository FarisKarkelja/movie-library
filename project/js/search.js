document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(
    '.search-container input[type="search"]'
  );

  if (searchInput) {
    searchInput.addEventListener("input", function (event) {
      const searchQuery = event.target.value.toLowerCase();
      const allCards = document.querySelectorAll(".tab-content .col");

      allCards.forEach(function (card) {
        const titleElement = card.querySelector(".card-title");
        if (titleElement) {
          const title = titleElement.textContent.toLowerCase();
          if (title.includes(searchQuery)) {
            card.style.display = "block";
          } else {
            card.style.display = "none";
          }
        }
      });
    });
  }
});
