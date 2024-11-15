<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');
$message = "";
$messageClass = "";

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $collectDataAccount = [];
    $collectDataUser = [];

    if(!empty($_POST["accountName"])){
        $accountName = mysqli_real_escape_string($conn, $_POST["accountName"]);
        $collectDataAccount[] = "accountName = '$accountName'";
    }
    if(!empty($_POST["password"])){
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $collectDataAccount[] = "password = '$password'";
    }

    if(!empty($_POST["userName"]) && !empty($_POST["userSurname"])){
        $userName = mysqli_real_escape_string($conn, $_POST["userName"] . ' ' . $_POST["userSurname"]);
        $collectDataUser[] = "userName = '$userName'";
    }
    if(!empty($_POST["userBirth"])){
        $userBirth = mysqli_real_escape_string($conn, $_POST["userBirth"]);
        $collectDataUser[] = "userBirth = '$userBirth'";
    }
    if(!empty($_POST["userHeight"])){
        $userHeight = mysqli_real_escape_string($conn, $_POST["userHeight"]);
        $collectDataUser[] = "userHeight = '$userHeight'";
    }
    if(!empty($_POST["userWeight"])){
        $userWeight = mysqli_real_escape_string($conn, $_POST["userWeight"]);
        $collectDataUser[] = "userWeight = '$userWeight'";
    }
    if(!empty($_POST["userPhone"])){
        $userPhone = mysqli_real_escape_string($conn, $_POST["userPhone"]);
        $collectDataUser[] = "userPhone = '$userPhone'";
    }
    if(!empty($_POST["userEmail"])){
        $userEmail = mysqli_real_escape_string($conn, $_POST["userEmail"]);
        $collectDataUser[] = "userEmail = '$userEmail'";
    }

    if(!empty($collectDataAccount) && !empty($collectDataUser)){
        $queryConsultAccount = "SELECT * FROM `accounts` WHERE `account_name` = '$accountName'";
        $resultAccount = mysqli_query($conn, $queryConsultAccount);

        $queryConsultEmail = "SELECT * FROM `users` WHERE `user_email` = '$userEmail'";
        $resultEmail = mysqli_query($conn, $queryConsultEmail);

        if(mysqli_num_rows($resultAccount) > 0){
            $message = "Este nome de usuário já está em uso. Por favor, escolha outro.";
            $messageClass = "boxError";
        } elseif(mysqli_num_rows($resultEmail) > 0) {
            $message = "Este e-mail já está em uso. Por favor, utilize outro.";
            $messageClass = "boxError";
        } else {
            $queryRegisterAccount = "INSERT INTO accounts (`account_name`, `account_passw`, `account_created`) VALUES ('$accountName', '$password', NOW())";
            if(mysqli_query($conn, $queryRegisterAccount)){
                $accountID = mysqli_insert_id($conn);
                $queryRegisterUser = "INSERT INTO users (`user_group`, `user_name`, `user_date_birth`, `user_weight`, `user_height`, `user_phone`, `user_email`, `account_id`) VALUES ('Usuário', '$userName', '$userBirth', '$userWeight', '$userHeight', '$userPhone', '$userEmail', '$accountID')";
                if(mysqli_query($conn, $queryRegisterUser)){         
                    $message = "Sua conta foi criada com sucesso!";
                    $messageClass = "boxSuccess";
                    header("Location: account.php");
                } else {
                    $message = "Algo deu errado ao cadastrar o usuário, mensagem do erro: " . mysqli_error($conn);
                    $messageClass = "boxError";
                }
            } else {
                $message = "Algo deu errado ao cadastrar a conta, mensagem do erro: " . mysqli_error($conn);
                $messageClass = "boxError";
            }
        }
    } else {
        $message = "Sua conta não foi criada, verifique os campos ou contate um Administrador!";
        $messageClass = "boxWarning";
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
            <img src="../layout/images/profile_register.png" class="image-profile">
            <div class="contentRegister">
                <center>Se registre para ter acesso ao nosso conteúdo!<br>Insira seus dados verdadeiro para que possamos nos basear e criar sua planilha de treino.</center><br>
                <form action="" method="POST">
                    <div class="contentRegisterRight">
                        <label for="accountName">Usuário:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="text" name="accountName" id="accountName" placeholder="Conta" ><br>

                        <label for="userName">Nome:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="text" name="userName" id="userName" placeholder="Primeiro Nome" required><br>
                        
                        <label for="userEmail">E-mail:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="email" name="userEmail" id="userEmail" placeholder="Seu melhor e-mail" required><br>

                        <label for="userWeight">Peso:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="number" name="userWeight" id="userWeight" placeholder="Seu peso" required><br>
                    </div>

                    <div class="contentRegisterLeft">
                        <label for="password">Senha:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="password" name="password" id="password" placeholder="Senha" required>
                        <i id="registerPassw" class="bi-eye-fill" onclick="showHide('password', 'registerPassw')"></i><br>

                        <label for="userSurname">Sobrenome:</label> <span style="font-size:10px; color:red;">*</span><br>
                        <input type="text" name="userSurname" id="userSurname" placeholder="Último Nome" required><br>

                        <label for="userPhone">Telefone:</label><br>
                        <input type="number" name="userPhone" id="userPhone" placeholder="Número de telefone" required><br>

                        <label for="userHeight">Altura:</label> <span style="font-size:10px; color:red;">*</span><br>
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