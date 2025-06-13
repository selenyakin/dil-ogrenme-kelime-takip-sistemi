<?php
// kaydol.php
// Formdan gelen verilerin veritabanına kayıt işlemi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'config.php'; // config.php dosyasını dahil et

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Bağlantı Hatası: " . $conn->connect_error);
    }

    $kullanici_adi = $_POST['kullanici_adi'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    if (empty($kullanici_adi) || empty($email) || empty($sifre)) {
        die("Lütfen tüm alanları doldurun!");
    }

    // Aynı kullanıcı adı veya e-posta var mı kontrol et
    $kontrol_sql = "SELECT * FROM Kullanicilar WHERE Kullanici_Adi = '$kullanici_adi' OR Kullanici_Email = '$email'";
    $sonuc = $conn->query($kontrol_sql);

    if ($sonuc->num_rows > 0) {
        echo '
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="4;url=kaydol.php">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Kayıt Hatası</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #fff4f4;
                    font-family: Arial, sans-serif;
                }
                .message-box {
                    background-color: #f8d7da;
                    padding: 30px 40px;
                    border-radius: 12px;
                    box-shadow: 0 0 12px rgba(0,0,0,0.1);
                    color: #842029;
                    font-size: 18px;
                    text-align: center;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                ❌ Bu kullanıcı adı veya e-posta zaten kayıtlı!<br>
                Lütfen farklı bir kullanıcı adı/e-posta deneyin...
            </div>
        </body>
        </html>
        ';
        exit();
    }

    // Şifreyi hash'le ve kayıt yap
    $hashli_sifre = password_hash($sifre, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Kullanicilar (Kullanici_Adi, Kullanici_Email, Kullanici_Sifre)
            VALUES ('$kullanici_adi', '$email', '$hashli_sifre')";

    if ($conn->query($sql) === TRUE) {
        echo '
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="3;url=index.php">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Kayıt Başarılı</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f0f4ff;
                    font-family: Arial, sans-serif;
                }
                .message-box {
                    background-color: #d1e7dd;
                    padding: 30px 40px;
                    border-radius: 12px;
                    box-shadow: 0 0 12px rgba(0,0,0,0.1);
                    color: #0f5132;
                    font-size: 20px;
                    text-align: center;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                ✅ Kayıt Başarıyla Tamamlandı!<br>
                Ana sayfaya yönlendiriliyorsunuz...
            </div>
        </body>
        </html>
        ';
        exit();
    } else {
        echo "Hata: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML Kayıt Formu -->
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>KAYIT OL</title>
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
    background-color: rgba(255, 255, 255, 0.75);
    max-width: 400px;
    margin: 80px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }
  h1 {
    color: #234fc2;
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
  }
</style>
</head>
<body>

<div class="form-container">
  <h1>Kayıt Ol</h1>
  <form action="kaydol.php" method="POST" novalidate>
    <div class="mb-3">
      <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
      <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" required>
    </div>
    <div class="mb-3">
      <label for="kullanici_email" class="form-label">E-Posta</label>
      <input type="email" class="form-control" id="kullanici_email" name="email" required>
    </div>
    <div class="mb-4">
      <label for="kullanici_sifre" class="form-label">Şifre</label>
      <input type="password" class="form-control" id="kullanici_sifre" name="sifre" required>
    </div>
    <button type="submit" class="btn w-100" style="background-color: #234fc2; color: white;">Kayıt Ol</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
