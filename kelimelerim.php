<?php 
session_start();

if(!isset($_SESSION['kullanici_id'])){
    header("Location: giris.php?oturum=kapandi");
    exit();
}

require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}



$kullanici_id = $_SESSION['kullanici_id'];

$sql = "SELECT Kelime_ID, Kelime, Kelime_Anlami, Ornek_Cumle, Kayit_Zamani 
        FROM Kelimeler 
        WHERE Kullanici_ID = '$kullanici_id' 
        ORDER BY Kayit_Zamani DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelimelerim</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

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

    </style>

</head>
<body>

<nav class="navbar border-bottom border-body" style="background-color: #234fc2;" data-bs-theme="dark">
  <div class="container-fluid">

    <a class="navbar-brand" href="#">Selen'CE (Dil Öğrenenler İçin Kelime Takibi)</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
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
          <a class="nav-link text-danger" href="cikis.php">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h2 style="background-color: #234fc2; color: #ffd55c ;" >Eklediğiniz Kelimeler</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kelime</th>
                <th>Anlamı</th>
                <th>Örnek Cümle</th>
                <th>Eklenme Tarihi</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Kelime']) ?></td>
                    <td><?= htmlspecialchars($row['Kelime_Anlami']) ?></td>
                    <td><?= htmlspecialchars($row['Ornek_Cumle']) ?></td>
                    <td><?= $row['Kayit_Zamani'] ?></td>
                    <td>
                        <a href="kelime_duzenle.php?kelime_id=<?= $row['Kelime_ID'] ?>">Düzenle</a> |
                        <form action="kelime_sil.php" method="POST" style="display:inline;" 
                              onsubmit="return confirm('Bu kelimeyi silmek istediğinizden emin misiniz?');">
                            <input type="hidden" name="kelime_id" value="<?= $row['Kelime_ID'] ?>">
                            <input type="submit" value="Sil" class="btn btn-link p-0" />
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Henüz Kelime Eklenmemiş.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="text-center mt-4">
    <a href="anasayfa.php" class="btn btn-lg" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;">Ana Sayfaya Git</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
