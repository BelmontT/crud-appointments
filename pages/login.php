<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');
    $message = "";
    $messageClass = "";

    session_start();
    if(isset($_SESSION["account_id"])){
        header("Location: account.php");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST['accountName']);
        $password = mysqli_real_escape_string($conn, $_POST['accountPassw']);
    
        $sql = ("SELECT * FROM accounts WHERE account_name = '$username' and account_passw = '$password'");
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $account = mysqli_fetch_assoc($result);
            $_SESSION["account_id"] = $account["account_id"];

            header("Location: account.php");
            exit();
        } else {
            $message = "Usuário ou senha inválida!";
            $messageClass = "boxError";
        }
    }
?>

<html lang="pt-BR">
    <head>
        <meta charSet="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Find your personal trainer and improve your training to achieve the shape you've always dreamed of.">
        <script type="text/javascript" src="../layout/javascript/function.js"></script>
        <link rel="stylesheet" type="text/css" href="../layout/css/style.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <title>Studio Vegas</title>
    </head>
    <header>
        <div class="header-content">
            <a href="../index.html"><img src="../layout/images/logo.png" title="Studio Vegas" class="image-logo"></a>
            <div class="profile-link profile-button">
                <i class="bi-person-circle"></i>
                <div class="profile-link-content">
                    <a href="plans.php"><i class="bi-list"></i> Planos</a>
                    <a href="login.php"><i class="bi-person-lines-fill"></i> Entrar</a>
                    <a href="register.php"><i class="bi-person-plus-fill"></i> Registrar</a>
                </div>
            </div>
        </div>
    </header>
    <body onload="hideMessage()">
        <div class="contentDiv">
            <?php if(!empty($message)): ?>
                <div id="messageBox" class="<?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <button onclick="history.back()" class="back"><i class="bi-reply" title="Voltar"></i></button>
            <img src="../layout/images/profile_login.png" class="image-profile">
            <div class="contentLogin">
                <form action="" method="POST">
                    <label for="accountName">Usuário:</label>
                    <input type="text" name="accountName" id="accountName" required> 
                        
                    <label for="accountPassw">Password:</label>
                    <input type="password" name="accountPassw" id="accountPassw" required> 
                    <i id="eye-password" class="bi-eye-fill" onclick="showHide('accountPassw', 'eye-password')"></i>
                        
                    <button type="submit" id="submitLogin" value="submitLogin">Entrar</button>
                    <a href="register.php" class="create-account"><span>Criar Conta</span></a>
                </form>
            </div>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html> 