<?php
    require("../database/db.php");

    session_destroy();
    header("Location: ../index.html");
    exit();
?>