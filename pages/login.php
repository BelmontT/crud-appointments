<?php
    require("../database/db.php");
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
            <img src="../layout/images/profile_login.png" class="image-profile">
            <div class="contentLogin">
                <form action="" method="POST">
                    <label for="accountName">Usuário:</label>
                    <input type="password" name="accountName" id="accountName" required> 
                    <i id="eye-account" class="bi-eye-fill" onclick="hideShow('accountName', 'eye-account')"></i>
                        
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required> 
                    <i id="eye-password" class="bi-eye-fill" onclick="hideShow('password', 'eye-password')"></i>
                        
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