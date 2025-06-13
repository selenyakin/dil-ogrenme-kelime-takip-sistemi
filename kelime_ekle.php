<?php
session_start();

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php?oturum=kapandi");
    exit();
}

$kullanici_id = $_SESSION['kullanici_id'];
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
     'config.php'; // config.php dosyasını dahil et

        require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}

    if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
    }

    $kelime = $_POST['kelime'];
    $anlami = $_POST['anlami'];
    $ornek = $_POST['ornek'];

    $kontrol = $conn->prepare("SELECT * FROM Kelimeler WHERE Kullanici_ID = ? AND Kelime = ?");
    $kontrol->bind_param("is", $kullanici_id, $kelime);
    $kontrol->execute();
    $kontrol_result = $kontrol->get_result();

    if ($kontrol_result->num_rows > 0) {
        $mesaj = "Bu kelimeyi zaten eklemişsiniz.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Kelimeler (Kullanici_ID, Kelime, Kelime_Anlami, Ornek_Cumle) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $kullanici_id, $kelime, $anlami, $ornek);

        if ($stmt->execute()) {
            $mesaj = "Kelime başarıyla eklendi!";
        } else {
            $mesaj = "Hata: " . $stmt->error;
        }

        $stmt->close();
    }

    $kontrol->close();
    $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kelime Ekle</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .form-container {
            background-color: #f0f4ff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            color: #234fc2;
        }

        .btn-custom {
            background-color: #fbf2e3;
            color: #234fc2;
            border: 3px solid #ed513b;
        }
    </style>
</head>
<body>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 form-container">
            <h3 class="text-center mb-4" style="color:#234fc2;">Yeni Kelime Ekle</h3>

            <?php if (!empty($mesaj)) : ?>
                <div class="alert alert-info text-center"><?= htmlspecialchars($mesaj) ?></div>
            <?php endif; ?>

            <form action="kelime_ekle.php" method="post">
                <div class="mb-3">
                    <label for="kelime">Kelime</label>
                    <input type="text" class="form-control" id="kelime" name="kelime" required>
                </div>

                <div class="mb-3">
                    <label for="anlami">Anlamı</label>
                    <textarea class="form-control" id="anlami" name="anlami" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="ornek">Örnek Cümle</label>
                    <textarea class="form-control" id="ornek" name="ornek" rows="3" required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-custom btn-lg px-5"> Ekle</button>
                    <a href="anasayfa.php" class="btn btn-custom btn-lg px-5">Ana Sayfa Git</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
