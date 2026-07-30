<?php

session_start();
session_destroy();

header("Location: /ta_deadlinehub/auth/login.php");
exit;

?>