<?php 
session_start();
if (!isset($_SESSION["user_id"]))
    die(header("Location: /bac/web/index.php"));
?>
