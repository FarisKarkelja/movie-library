<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/db.php';

$movies = [];
$series = [];

try {
    $stmt = $pdo->query("SELECT id, title, img_url FROM movies WHERE img_url IS NOT NULL AND img_url <> '' ORDER BY id DESC"); 
    $movies = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT id, title, img_url FROM series WHERE img_url IS NOT NULL AND img_url <> '' ORDER BY id DESC"); 
    $series = $stmt->fetchAll(); 
} catch (Throwable $e) { 
    $movies = [];
    $series = [];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>unwind</title>
    <link rel="stylesheet" href="https://cdn.lineicons.com/5.0/lineicons.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"
    />
    <link href="./css/style.css" rel="stylesheet" />
  </head>
  <body>
    <section class="header-section">
      <div class="header-text">
        <h1>
          <img src="./images/logo-no-bg.png" alt="unwind" class="title-word" />
        </h1>
        <h2>Sit Back. Press Play.</h2>
      </div>
      <nav class="navbar navbar-expand-lg py-4 py-lg-0 shadow">
        <div class="container px-4">
          <a href="index.php">
            <img class="logo" src="./images/logo.png" alt="Logo" />
          </a>
          <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#top-navbar"
            aria-controls="top-navbar"
          >
            <i class="fa-solid fa-bars"></i>
          </button>
          <div
            class="offcanvas offcanvas-end"
            tabindex="-1"
            id="top-navbar"
            aria-labelledby="top-navbarLabel"
          >
            <button
              class="navbar-toggler border-0"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#top-navbar"
              aria-controls="top-navbar"
            >
              <div class="d-flex justify-content-between p-3">
                <img class="logo" src="./images/logo.png" alt="Logo" />
                <i class="fa-solid fa-xmark"></i>
              </div>
            </button>
            <ul class="navbar-nav ms-lg-auto p-4 p-lg-0">
              <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                <a class="nav-link" href="library.html">Library</a>
              </li>
              <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                <a class="nav-link" href="about.html">About</a>
              </li>
              <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                <a class="nav-link" href="contact.html">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </section>

    <h2 class="slider-title">MOVIES</h2>
    <div class="slider mt-5 mb-5">
      <div class="slide-track">
        <?php if (!empty($movies)): ?>
        <?php foreach ($movies as $m): ?>
        <div class="slide">
          <img
            src="<?= htmlspecialchars($m['img_url'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($m['title'] ?? 'Movie', ENT_QUOTES, 'UTF-8') ?>"
          />
        </div>
        <?php endforeach; ?>
        <?php foreach ($movies as $m): ?>
        <div class="slide">
          <img
            src="<?= htmlspecialchars($m['img_url'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($m['title'] ?? 'Movie', ENT_QUOTES, 'UTF-8') ?>"
          />
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center w-100 py-5">No movies found.</div>
        <?php endif; ?>
      </div>
    </div>

    <h2 class="slider-title">TV SHOWS</h2>
    <div class="slider mt-5 mb-5">
      <div class="slide-track-reverse">
        <?php if (!empty($series)): ?>
        <?php foreach ($series as $s): ?>
        <div class="slide">
          <img
            src="<?= htmlspecialchars($s['img_url'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($s['title'] ?? 'Series', ENT_QUOTES, 'UTF-8') ?>"
          />
        </div>
        <?php endforeach; ?>
        <?php foreach ($series as $s): ?>
        <div class="slide">
          <img
            src="<?= htmlspecialchars($s['img_url'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($s['title'] ?? 'Series', ENT_QUOTES, 'UTF-8') ?>"
          />
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center w-100 py-5">No tv shows found.</div>
        <?php endif; ?>
      </div>
    </div>

    <h2 class="slider-title">TRAILERS</h2>
    <div class="slider mb-5">
      <div class="slide-track-trailers">
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/NZ_OheD3ops?si=1ZydQOcG48NCp4yC&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/az8M5Mai0X4?si=13cRpBnVsi8N9xYL&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/GXecSGmQDEI?si=Zfb9tdzOBL-A5mLD&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/mzWQKABk79g?si=CWM38BiahD_G_vw5&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/Ej56M-ePzf8?si=IpqzUVlL__IHA_3i&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>

        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/NZ_OheD3ops?si=1ZydQOcG48NCp4yC&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/az8M5Mai0X4?si=13cRpBnVsi8N9xYL&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/GXecSGmQDEI?si=Zfb9tdzOBL-A5mLD&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/mzWQKABk79g?si=CWM38BiahD_G_vw5&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/Ej56M-ePzf8?si=IpqzUVlL__IHA_3i&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>

        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/NZ_OheD3ops?si=1ZydQOcG48NCp4yC&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/az8M5Mai0X4?si=13cRpBnVsi8N9xYL&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/GXecSGmQDEI?si=Zfb9tdzOBL-A5mLD&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/mzWQKABk79g?si=CWM38BiahD_G_vw5&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
        <div class="slide">
          <iframe
            width="600"
            height="200"
            src="https://www.youtube.com/embed/Ej56M-ePzf8?si=IpqzUVlL__IHA_3i&mute=1"
            title="YouTube video player"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>

    <footer>
      <div class="footer-content">
        <p class="tagline">Sit back. Press play.</p>
        <img
          src="./images/logo-no-bg.png"
          alt="Unwind Logo"
          class="footer-logo"
        />
        <p class="copy">&copy; 2025 unwind</p>
        <nav class="footer-nav">
          <a href="index.php">Home</a>
          <a href="library.html">Library</a>
          <a href="about.html">About</a>
          <a href="contact.html">Contact</a>
        </nav>
      </div>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
