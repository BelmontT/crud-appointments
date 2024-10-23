<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');

    session_start();
    $_SESSION = array();

    session_destroy();
    header("Location: account.php");
    exit();
?>