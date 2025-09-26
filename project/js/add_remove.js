(function () {
  const STORAGE_KEYS = {
    watched: "movies_watched",
    watchlist: "movies_watchlist",
  };

  const addBtn = document.querySelector(".add-btn");

  init();

  function init() {
    Object.entries(STORAGE_KEYS).forEach(([paneId, key]) => {
      if (!localStorage.getItem(key)) {
        const data = readCardsFromDOM(paneId);
        saveList(key, data);
      }
    });

    renderAll();

    addBtn?.addEventListener("click", onAdd);
    document.addEventListener("click", onDeleteClick);
  }

  function readCardsFromDOM(paneId) {
    const container = document.querySelector(`#${paneId} .cards`);
    if (!container) return [];
    const cards = [...container.querySelectorAll(".card")];
    return cards.map((card) => {
      const img = card.querySelector("img");
      const title = card.querySelector(".card-title");
      return {
        id: crypto.randomUUID(),
        title: (title?.textContent || "Untitled").trim(),
        img: img?.getAttribute("src") || "../images/card-img.jpg",
      };
    });
  }

  function getActivePaneId() {
    const pane = document.querySelector(".tab-pane.active.show");
    if (pane) return pane.id;
    const link = document.querySelector(".nav-link.active");
    if (link)
      return (link.getAttribute("href") || "").replace("#", "") || "watched";
    return "watched";
  }

  function onAdd() {
    const activePane = getActivePaneId();
    if (!STORAGE_KEYS[activePane]) return;

    const title = prompt("Enter movie title:");
    if (title === null) return;
    const trimmedTitle = title.trim();
    if (!trimmedTitle) {
      alert("Title required.");
      return;
    }
    let img = prompt("Enter image URL (leave empty for default):") || "";
    img = img.trim() || "../images/card-img.jpg";

    const listKey = STORAGE_KEYS[activePane];
    const list = loadList(listKey);
    list.push({
      id: crypto.randomUUID(),
      title: trimmedTitle,
      img,
    });
    saveList(listKey, list);
    renderList(activePane);
  }

  function onDeleteClick(e) {
    const btn = e.target.closest(".delete-btn");
    if (!btn) return;
    const card = btn.closest(".col");
    if (!card) return;
    const pane = card.closest(".tab-pane");
    if (!pane) return;
    const paneId = pane.id;
    const listKey = STORAGE_KEYS[paneId];
    if (!listKey) return;

    const movieId = card.dataset.id;
    let list = loadList(listKey);
    list = list.filter((m) => m.id !== movieId);
    saveList(listKey, list);
    card.remove();
  }

  function loadList(key) {
    try {
      return JSON.parse(localStorage.getItem(key)) || [];
    } catch {
      return [];
    }
  }

  function saveList(key, list) {
    localStorage.setItem(key, JSON.stringify(list));
  }

  function renderAll() {
    Object.keys(STORAGE_KEYS).forEach((paneId) => renderList(paneId));
  }

  function renderList(paneId) {
    const listKey = STORAGE_KEYS[paneId];
    const container = document.querySelector(`#${paneId} .cards`);
    if (!container) return;
    const list = loadList(listKey);

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
        img.src = "../images/card-img.jpg";
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
