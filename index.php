<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Selen'CE</title>
<link rel="icon" href="src/logo.PNG" type="image/png">
<style>
  body, html {
    margin: 0; padding: 0; min-height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url('src/arka_plan.PNG') no-repeat center center fixed;
    background-size: cover;
  }

  /* NAVBAR */
  nav {
    position: fixed;
    top: 0; left: 0; width: 100%;
    height: 80px;
    background-color: #ffd55c;
    display: flex;
    align-items: center;
    padding: 0 20px;
    box-sizing: border-box;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    z-index: 1000;
  }
  nav .logo {
  width: 80px;
  height: 80px;
  margin-right: 20px;
}

  nav .logo img {
    max-width: 100%;
    max-height: 100%;
    display: block;
  }
  nav .site-name {
    font-weight: 700;
    font-size: 1.3rem;
    color: #ed513b;
  }

  /* İçerik kutusu */
  .overlay {
    min-height: 100vh;
    padding-top: 80px; /* navbar yüksekliği + boşluk */
    background-color: rgba(255,255,255,0.38);

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    padding-left: 20px;
    padding-right: 20px;
    box-sizing: border-box;
  }

  h1 {
    color: #234fc2;
    margin-bottom: 10px;
    font-size: 3rem;
    text-align: center;
  }

  p.intro {
    color: #555;
    font-size: 1.25rem;
    max-width: 500px;
    margin: 0 auto 30px;
    text-align: center;
  }

  .buttons {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 40px;
  }

  .btn {
    background-color: #fbf2e3;
    color: #234fc2;
    border: 4px solid #ed513b;
    border-radius: 12px;
    padding: 14px 40px;
    font-size: 1.25rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 6px 0 #ed513b;
    cursor: pointer;
  }
  .btn:hover {
    background-color: #ed513b;
    color: #fff;
    box-shadow: 0 2px 0 #a73626;
  }

  /* Özellikler kutuları */
  .features {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
    max-width: 900px;
  }
  .feature-item {
    background-color: #f0f4ff;
    border-radius: 15px;
    padding: 20px;
    width: 200px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
  }
  .feature-icon {
    font-size: 3rem;
    color: #234fc2;
    margin-bottom: 15px;
  }
  .feature-title {
    font-weight: 700;
    margin-bottom: 10px;
    color: #234fc2;
  }
  .feature-desc {
    color: #555;
    font-size: 0.9rem;
  }


  .developer-info {
    margin-top: 40px;
    max-width: 600px;
    background-color: #f0f4ff;
    border-radius: 15px;
    padding: 20px 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    color: #234fc2;
    font-size: 1rem;
    text-align: center;
    font-style: italic;
  }


  @media(max-width: 600px){
    h1 { font-size: 2.2rem;}
    .btn {
      padding: 12px 28px;
      font-size: 1rem;
    }
    .feature-item {
      width: 100%;
      max-width: 300px;
    }
    .developer-info {
      max-width: 90%;
      font-size: 0.9rem;
      padding: 15px 20px;
    }
  }

</style>
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<nav>
  <div class="logo">
    <img src="src/logo.PNG" alt="Selen'CE Logo" />
  </div>
  <div class="site-name">Selen'CE (Dil Öğrenenler İçin Kelime Takibi)</div>
</nav>

<div class="overlay">
  
  <h1>Kelime Takip Sistemine Hoş Geldiniz!</h1>
  <p class="intro">
    İngilizce veya istediğiniz dili kolayca öğrenmek için kelimelerinizi takip edin, pratik yapın ve gelişiminizi görün.
  </p>

  <div class="buttons">
    <a href="giris.php" class="btn">Giriş Yap</a>
    <a href="kaydol.php" class="btn">Kayıt Ol</a>
  </div>

  <div class="features">
    <div class="feature-item">
      <div class="feature-icon"><i class="fas fa-check-circle"></i></div>
      <div class="feature-title">Kolay Takip</div>
      <div class="feature-desc">Kelime öğreniminizi pratik ve düzenli takip edin.</div>
    </div>
  </div>

  <div class="developer-info">
    <p><strong>Geliştiren:</strong> Selen Yakın</p>
  </div>
</div>

</body>
</html>
