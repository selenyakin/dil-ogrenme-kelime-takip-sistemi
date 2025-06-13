<?php
session_start();

if (!isset($_SESSION['kullanici_id'])) {
    die("Bu sayfayı görmek için giriş yapmalısınız!");
}

require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guncelle'])) {
    $kelime_id = $_POST['kelime_id'];
    $kelime = $conn->real_escape_string($_POST['kelime']);
    $anlami = $conn->real_escape_string($_POST['anlami']);
    $ornek = $conn->real_escape_string($_POST['ornek']);

    $sql = "UPDATE Kelimeler 
            SET Kelime='$kelime', Kelime_Anlami='$anlami', Ornek_Cumle='$ornek' 
            WHERE Kelime_ID='$kelime_id' AND Kullanici_ID='" . $_SESSION['kullanici_id'] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='container mt-4'><div class='alert alert-success'>Kelime başarıyla güncellendi. 
        <a href='kelimelerim.php' class='btn btn-sm btn-primary ms-2'>Geri dön</a></div></div>";
    } else {
        echo "<div class='container mt-4'><div class='alert alert-danger'>Güncelleme hatası: " . $conn->error . "</div></div>";
    }

    $conn->close();
    exit;
}

if (isset($_GET['kelime_id'])) {
    $kelime_id = $_GET['kelime_id'];

    $sql = "SELECT * FROM Kelimeler 
            WHERE Kelime_ID='$kelime_id' AND Kullanici_ID='" . $_SESSION['kullanici_id'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $kelime = $row['Kelime'];
        $anlami = $row['Kelime_Anlami'];
        $ornek = $row['Ornek_Cumle'];
    } else {
        echo "<div class='alert alert-warning m-4'>Kelime bulunamadı ya da size ait değil.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning m-4'>Kelime ID bulunamadı.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kelime Düzenle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('src/arka_plan.PNG') no-repeat center center fixed;
            background-size: cover;
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

<nav class="navbar navbar-expand-lg" style="background-color: #234fc2;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Selen'CE (Dil Öğrenenler İçin Kelime Takibi)</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Menüyü Aç/Kapat">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="kelimelerim.php">Kelimelerim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kelime_ekle.php">Kelime Ekle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="cikis.php">Çıkış Yap</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- FORM -->
<div class="container mt-5">
    <div class="p-4 shadow rounded-4" style="background-color: #f0f4ff;">
        <h2 class="text-center mb-4" style="color: #234fc2;">Kelimeyi Düzenle</h2>

        <form method="POST" action="kelime_guncelle.php">
            <input type="hidden" name="kelime_id" value="<?php echo htmlspecialchars($kelime_id); ?>">

            <div class="mb-3">
                <label class="form-label">Kelime</label>
                <input type="text" class="form-control" name="kelime" value="<?php echo htmlspecialchars($kelime); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Anlamı</label>
                <input type="text" class="form-control" name="anlami" value="<?php echo htmlspecialchars($anlami); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Örnek Cümle</label>
                <textarea class="form-control" name="ornek" rows="4" required><?php echo htmlspecialchars($ornek); ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="kelimelerim.php" class="btn" style="background-color: #ed513b; color: white;">Vazgeç</a>
                <button type="submit" name="guncelle" class="btn" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;"">Güncelle</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
