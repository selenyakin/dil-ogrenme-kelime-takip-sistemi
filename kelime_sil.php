<?php
session_start();

if (!isset($_SESSION['kullanici_id'])) {
    die("Giriş yapmalısınız.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Geçersiz istek yöntemi.");
}

if (!isset($_POST['kelime_id'])) {
    die("Geçersiz kelime ID'si.");
}

$kelime_id = intval($_POST['kelime_id']);
$kullanici_id = $_SESSION['kullanici_id'];

require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}

$sql = "DELETE FROM Kelimeler WHERE Kelime_ID = ? AND Kullanici_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $kelime_id, $kullanici_id);

$mesaj = "";
$basarili = false;

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $mesaj = "Kelime başarıyla silindi.";
        $basarili = true;
    } else {
        $mesaj = "Silinecek kelime bulunamadı veya yetkiniz yok.";
    }
} else {
    $mesaj = "Silme işlemi sırasında hata oluştu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Kelime Silme Sonucu</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: url('src/arka_plan.PNG') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            z-index: 0;
            background-color: rgba(255, 255, 255, 0.4);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 480px;
            margin: 80px auto;
            background-color: #fff;
            padding: 30px 40px;
            box-shadow: 0 8px 16px rgba(85, 104, 175, 0.15);
            border-radius: 12px;
            text-align: center;
        }
        h1 {
            color: #234fc2; 
            margin-bottom: 24px;
            font-size: 1.8rem;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 32px;
        }
        .success {
            color: #28a745; 
        }
        .error {
            color: #dc3545; 
        }
        a {
            text-decoration: none;
            background-color: #234fc2;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        a:hover {
            background-color: #3f5277;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelime Silme İşlemi</h1>
        <p class="<?= $basarili ? 'success' : 'error' ?>"><?= htmlspecialchars($mesaj) ?></p>
        <a href="kelimelerim.php">Kelimelerime dön</a>
    </div>
</body>
</html>
