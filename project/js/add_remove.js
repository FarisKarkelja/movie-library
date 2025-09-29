(function () {
  const addBtn = document.querySelector(".add-btn");

  init();

  function init() {
    renderAll();

    addBtn?.addEventListener("click", onAdd);
    document.addEventListener("click", onDeleteClick);
  }

  function getActivePaneId() {
    const pane = document.querySelector(".tab-pane.active.show");
    if (pane) return pane.id;
    const link = document.querySelector(".nav-link.active");
    if (link)
      return (link.getAttribute("href") || "").replace("#", "") || "watched";
    return "watched";
  }

  async function onAdd() {
    const activePane = getActivePaneId();

    const title = prompt("Enter movie title:");
    if (title === null) return;
    const trimmedTitle = title.trim();
    if (!trimmedTitle) {
      alert("Title required.");
      return;
    }
    let img = prompt("Enter image URL (leave empty for default):") || "";
    img = img.trim() || "./images/card-img.jpg";

    await fetch("library.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "add",
        title: trimmedTitle,
        img: img,
        listType: activePane,
      }),
    });

    renderList(activePane);
  }

  async function onDeleteClick(e) {
    const btn = e.target.closest(".delete-btn");
    if (!btn) return;
    const card = btn.closest(".col");
    if (!card) return;
    const pane = card.closest(".tab-pane");
    if (!pane) return;
    const paneId = pane.id;

    const movieId = card.dataset.id;

    await fetch("library.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "delete",
        id: movieId,
      }),
    });

    card.remove();
  }

  function renderAll() {
    ["watched", "watchlist"].forEach((paneId) => renderList(paneId));
  }

  async function renderList(paneId) {
    const container = document.querySelector(`#${paneId} .cards`);
    if (!container) return;

    const res = await fetch(`library.php?action=list&listType=${paneId}`);
    const list = await res.json();

    container.innerHTML = "";

    list.forEach((movie) => {
      const col = document.createElement("div");
      col.className = "col";
      col.dataset.id = movie.id;

      const card = document.createElement("div");
      card.className = "card h-100";

      const img = document.createElement("img");
      img.className = "card-img-top";
      img.alt = movie.title;
      img.src = movie.img;
      img.addEventListener("error", () => {
        img.src = "./images/card-img.jpg";
      });

      const body = document.createElement("div");
      body.className = "card-body";

      const h5 = document.createElement("h5");
      h5.className = "card-title";
      h5.textContent = movie.title;

      const delBtn = document.createElement("button");
      delBtn.className = "delete-btn";
      delBtn.innerHTML = '<i class="fa-solid fa-minus"></i>';
      delBtn.setAttribute("aria-label", "Remove movie");

      body.appendChild(h5);
      body.appendChild(delBtn);
      card.appendChild(img);
      card.appendChild(body);
      col.appendChild(card);
      container.appendChild(col);
    });
  }
})();
