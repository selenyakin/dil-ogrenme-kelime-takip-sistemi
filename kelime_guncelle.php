<?php 
session_start();

if (!isset($_SESSION['kullanici_id'])) {
    die("Bu sayfayı görüntülemek için giriş yapmalısınız.");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kelime Güncelleme</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background: url('src/arka_plan.PNG') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg" style="background-color: #234fc2;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Selen'CE (Dil Öğrenenler İçin Kelime Takibi)</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Menüyü Aç/Kapat">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="kelimelerim.php">Kelimelerim</a>
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

<!-- SONUÇ MESAJI -->
<div class="container mt-5">
    <div class="p-4 shadow rounded-4" style="background-color: #f8f9fa;">

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $kelime_id = intval($_POST['kelime_id']); 
    $kelime = trim($_POST['kelime']); 
    $anlami = trim($_POST['anlami']); 
    $ornek = trim($_POST['ornek']);   
    $kullanici_id = $_SESSION['kullanici_id']; 

    if (empty($kelime) || empty($anlami)) {
        echo "<div class='alert alert-warning'>Kelime ve anlam alanları boş bırakılamaz.</div>";
    } else {
        require_once 'config.php'; // config.php dosyasını dahil et

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            die("Bağlantı Hatası: " . $conn->connect_error);
        }



        if ($conn->connect_error) {
            echo "<div class='alert alert-danger'>Bağlantı hatası: " . $conn->connect_error . "</div>";
        } else {
            $sql = "UPDATE Kelimeler 
                    SET Kelime = ?, Kelime_Anlami = ?, Ornek_Cumle = ? 
                    WHERE Kelime_ID = ? AND Kullanici_ID = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssii", $kelime, $anlami, $ornek, $kelime_id, $kullanici_id);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo "<div class='alert alert-success'>Kelime başarıyla güncellendi.</div>";
                    } else {
                        echo "<div class='alert alert-info'>Güncelleme yapıldı ancak içerik değişmedi veya kelime size ait değil.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Güncelleme sırasında bir hata oluştu: " . $stmt->error . "</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='alert alert-danger'>Sorgu hazırlanırken hata oluştu.</div>";
            }

            $conn->close();
        }
    }
} else {
    echo "<div class='alert alert-warning'>Geçersiz istek yöntemi.</div>";
}
?>

        <div class="mt-4 text-end">
            <a href="kelimelerim.php" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;">Kelimelerime Dön</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
