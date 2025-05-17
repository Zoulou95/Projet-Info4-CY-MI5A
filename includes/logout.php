<?php
// logout.php : disconnect a user
session_start();
session_unset();
session_destroy();
setcookie("identification", "", time() - 3600, "/");
header("Location: ../index.php");
exit();
?>