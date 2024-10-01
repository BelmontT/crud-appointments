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
    <body>
        <div class="contentDiv">
            <img src="../layout/images/profile_register.png" class="image-profile">
            <div class="contentRegister">
                <center>Se registre para ter acesso ao nosso conteúdo!<br>Insira seus dados verdadeiro para que possamos nos basear e criar sua planilha de treino.</center><br>
                <form action="" method="POST">
                    <div class="contentRegisterRight">
                        <label for="accountName">Usuário:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="password" name="accountName" id="accountName" placeholder="Conta" required><br>

                        <label for="userName">Nome:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="text" name="userName" id="userName" placeholder="Primeiro Nome" required><br>
                        
                        <label for="email">E-mail:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="email" name="email" id="email" placeholder="Seu melhor e-mail" required><br>

                        <label for="userWeight">Peso:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="number" name="userWeight" id="userWeight" placeholder="Seu peso" required><br>
                    </div>

                    <div class="contentRegisterLeft">
                        <label for="password">Senha:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="password" name="password" id="password" placeholder="Senha" required><br>

                        <label for="userSuname">Sobrenome:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="text" name="userSuname" id="userSuname" placeholder="Último Nome" required><br>

                        <label for="usarPhone">Telefone:</label><br>
                        <input type="number" name="usarPhone" id="usarPhone" placeholder="Número de telefone"><br>

                        <label for="userHeight">Altura:</label><span style="font-size:10px; color:red; margin:0px 5px 0px;">*</span><br>
                        <input type="number" name="userHeight" id="userHeight" placeholder="Sua altura" required><br>
                    </div>
                    <button id="submitRegister" value="submitRegister">Registrar</button>
                </form>
            </div>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>