<?php
session_start();

// Kullanıcı giriş yapmış mı kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php?oturum=kapandi");
    exit();
}

$kullanici_adi = $_SESSION['kullanici_adi'] ?? "Kullanıcı";
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ANA SAYFA</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('src/arka_plan.PNG') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            z-index: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(255, 255, 255, 0.4);
            z-index: -1;
        }

        .navbar-brand img {
            width: 60px;
            height: 60px;
            margin-right: 12px;
        }

        .navbar-brand span {
            color: #ffd55c;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar border-bottom border-body" style="background-color: #234fc2;" data-bs-theme="dark">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="src/logo.PNG" alt="Logo">
        <span>Selen'CE (Dil Öğrenenler İçin Kelime Takibi)</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="anasayfa.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kelimelerim.php">Kelimelerim</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kelime_ekle.php">Kelime Ekle</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profil.php">Profilim</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="cikis.php">Çıkış</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="p-5 text-center rounded-4 shadow" style="background-color: #f0f4ff;">
        <h2 class="fw-bold" style="color: #234fc2;">
         Hoş Geldin, <?= htmlspecialchars($kullanici_adi) ?>
        </h2>
        <p class="fs-5 mt-3" style="color: #555;">
          Kelime Takip Sistemine Hoş Geldiniz
        </p>
    </div>
</div>

<div class="container text-center mt-4">
    <div class="row">
        <div class="col">
            <a class="btn btn-lg" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;" href="kelimelerim.php">Kelimelerim</a>
        </div>
        <div class="col">
            <a class="btn btn-lg" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;" href="kelime_ekle.php">Kelime Ekle</a>
        </div>
        <div class="col">
            <a class="btn btn-lg" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;" href="profil.php">Profilim</a>
        </div>
        <div class="col">
            <a class="btn btn-lg" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;" href="cikis.php">Çıkış</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
