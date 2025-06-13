
-- KULLANICI TABLOSU (Kullanıcılar için)

CREATE TABLE Kullanicilar (
    Kullanici_ID  INT PRIMARY KEY AUTO_INCREMENT ,
    Kullanici_Adi VARCHAR(65) UNIQUE ,
    Kullanici_Email VARCHAR(100) ,
    Kullanici_Sifre VARCHAR(250) ,  -- ! şifre hash’li olacak!
    Olusturulma_Tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

-- KELİMELER Tablosu (Kelime kayıtları için)

CREATE TABLE Kelimeler(
    Kelime_ID INT PRIMARY KEY AUTO_INCREMENT ,
    Kullanici_ID INT 
,
    Kelime VARCHAR(200) ,
    Kelime_Anlami TEXT ,
    Ornek_Cumle TEXT ,
    Kayit_Zamani TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    FOREIGN KEY (Kullanici_ID) REFERENCES Kullanicilar(Kullanici_ID)
);