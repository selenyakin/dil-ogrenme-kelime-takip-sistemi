<?php 
session_start();

// Zaten giriş yapmışsa yönlendir
if (isset($_SESSION['kullanici_id'])) {
    header("Location: anasayfa.php");
    exit();
}

$mesaj = "";

// Çıkıştan sonra geldiyse mesaj göster
if (isset($_GET['cikis']) && $_GET['cikis'] == '1') {
    $mesaj = "Başarıyla çıkış yaptınız. Lütfen tekrar giriş yapın.";
}

// Giriş işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    if (empty($email) || empty($sifre)) {
        $mesaj = "Lütfen e-posta ve şifrenizi giriniz.";
    } else {
        require_once 'config.php'; // config.php dosyasını dahil et

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}

        if ($conn->connect_error) {
            die("Bağlantı Hatası: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Kullanicilar WHERE Kullanici_Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $kullanici = $result->fetch_assoc();

            if (password_verify($sifre, $kullanici['Kullanici_Sifre'])) {
                $_SESSION['kullanici_id'] = $kullanici['Kullanici_ID'];
                $_SESSION['kullanici_adi'] = $kullanici['Kullanici_Adi'];
                header("Location: anasayfa.php");
                exit();
            } else {
                $mesaj = "Hatalı şifre!";
            }
        } else {
            $mesaj = "Böyle bir kullanıcı bulunamadı.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Giriş Yap</title>
    <link rel="icon" href="src/logo.PNG" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      body, html {
        height: 100%;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('src/arka_plan.PNG') no-repeat center center fixed;
        background-size: cover;
      }
      .form-container {
        background-color: rgba(255, 255, 255, 0.7);
        max-width: 400px;
        margin: 80px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      }
      h1, h2 {
        color: #234fc2;
        text-align: center;
        margin-bottom: 25px;
        font-weight: 700;
      }
    </style>
</head>
<body>

<div class="form-container">
  <h2>Giriş Yap</h2>

  <?php if (!empty($mesaj)): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($mesaj) ?></div>

    <div class="d-flex justify-content-center gap-3 mt-3">
      <a class="btn btn-lg" href="giris.php" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;">Tekrar Deneyin</a>
      <a class="btn btn-lg" href="javascript:history.back()" style="background-color: #fbf2e3; color: #234fc2; border: 5px solid #ed513b;">Geri Dön</a>
    </div>
  <?php endif; ?>

  <form action="giris.php" method="POST" novalidate>
    <div class="mb-3">
      <label for="email" class="form-label">E-Posta</label>
      <input type="email" id="email" name="email" class="form-control" required />
    </div>
    <div class="mb-4">
      <label for="sifre" class="form-label">Şifre</label>
      <input type="password" id="sifre" name="sifre" class="form-control" required />
    </div>
    <button type="submit" class="btn w-100" style="background-color: #234fc2; color: white;">Giriş Yap</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
