<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
    
    $conn = mysqli_connect($config["database"]["host"], $config["database"]["user"], $config["database"]["password"], $config["database"]["name"]);
    if(!$conn){
        die("Erro na conexão: " . mysqli_connect_error());
        exit();
    }
?>