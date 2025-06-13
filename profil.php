<?php 

session_start();

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit();
}

$kullanici_id = $_SESSION['kullanici_id'];

require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}


$sql = "SELECT Kullanici_Adi, Kullanici_Email, Olusturulma_Tarihi FROM Kullanicilar WHERE Kullanici_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$stmt->bind_result($kullanici_adi, $email, $olusturma_tarihi);

if (!$stmt->fetch()) {
    $kullanici_adi = "Bilinmiyor";
    $email = "Bilinmiyor";
    $olusturma_tarihi = null;
}
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profilim</title>
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
        .card-custom {
            max-width: 400px;
            margin: 60px auto;
            border: 3px solid #ed513b;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }
        .card-custom .card-header {
            background-color: #234fc2;
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .btn-custom {
            background-color: #fbf2e3;
            color: #234fc2;
            border: 3px solid #ed513b;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #ed513b;
            color: #fff;
            border-color: #234fc2;
        }
    </style>
</head>
<body>

    <div class="card card-custom">
        <div class="card-header">
            Profil Bilgileri
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($kullanici_adi); ?></p>
            <p class="card-text"><strong>E-posta:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p class="card-text"><strong>Kayıt Tarihi:</strong> 
                <?php 
                    echo $olusturma_tarihi ? 
                    htmlspecialchars(date('d-m-Y H:i', strtotime($olusturma_tarihi))) : "Bilinmiyor"; 
                ?>
            </p>
            <a href="anasayfa.php" class="btn btn-custom btn-lg w-100 mt-3">Ana Sayfa Git</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
