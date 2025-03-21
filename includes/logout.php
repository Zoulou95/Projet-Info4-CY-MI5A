<?php
    // SUPPRIMER COOKIES
    session_start();
    session_destroy();
    header("Location: ../index.php");
    exit;
?>