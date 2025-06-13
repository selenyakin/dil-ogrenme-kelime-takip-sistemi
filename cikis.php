<?php
session_start();
session_unset();            // Oturum verilerini temizle
session_destroy();  
    
// hosgeldin.php sayfasına yönlendir
header("Location: index.php?cikis=1");
exit();
?>

