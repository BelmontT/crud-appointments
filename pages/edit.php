<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');
    $message = "";
    $messageClass = "";

    session_start();
    if(!isset($_SESSION["account_id"])){
        header("Location: login.php");
        exit();
    }
    
    $data = $_SESSION['account_id'];
    $queryAccount = ("SELECT * FROM accounts WHERE account_id = ' $data'");
    $resultAccount = mysqli_query($conn, $queryAccount);
    $account = mysqli_fetch_assoc($resultAccount);
    
    $queryUser = ("SELECT * FROM users WHERE account_id = ' $data'");
    $resultUser = mysqli_query($conn, $queryUser);
    $user = mysqli_fetch_assoc($resultUser);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $updateFieldsUser = [];
        $updateFieldsAccount = [];
        
        if (!empty($_POST["editPhone"])) {
            $phone = mysqli_real_escape_string($conn, $_POST["editPhone"]);
            $updateFieldsUser[] = "user_phone = '$phone'";
        }
    
        if (!empty($_POST["editEmail"])) {
            $email = mysqli_real_escape_string($conn, $_POST["editEmail"]);
            $updateFieldsUser[] = "user_email = '$email'";
        }
    
        if (!empty($_POST["editPassw"])) {
            $password = mysqli_real_escape_string($conn, $_POST["editPassw"]);
            $updateFieldsAccount[] = "account_passw = '$password'";
        }

        if (!empty($updateFieldsUser)) {
            $queryUpdateUser = "UPDATE users SET " . implode(", ", $updateFieldsUser) . " WHERE account_id = '$data'";
            if (mysqli_query($conn, $queryUpdateUser)){
                $message = "Dados atualizados com sucesso!";
                $messageClass = "boxSuccess";
            } else {
                $message = "Erro ao atualizar os dados: " . mysqli_error($conn);
                $messageClass = "boxError";
            }
        }

        if (!empty($updateFieldsAccount)) {
            $queryUpdateAccount = "UPDATE accounts SET " . implode(", ", $updateFieldsAccount) . " WHERE account_id = '$data'";
            if (mysqli_query($conn, $queryUpdateAccount)){
                $message = "Dados atualizados com sucesso!";
                $messageClass = "boxSuccess";
            } else {
                $message = "Erro ao atualizar os dados: " . mysqli_error($conn);
                $messageClass = "boxError";
            }
        }
    
        if (empty($updateFieldsUser) && empty($updateFieldsAccount)){
            $message = "Nenhuma alteração feita.";
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
    <body>
        <div class="contentDiv">
            <?php if(!empty($message)): ?>
                <div id="messageBox" class="<?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <button onclick="history.back()" class="back"><i class="bi-reply" title="Voltar"></i></button>
            <a href="logout.php" class="logout"><i class="bi-power" title="Sair"></i></a>
            <img src="../layout/images/profile_edit.png" class="image-profile">
            <center>Mantenha sua conta sempre segura, mude informações caso haja necessidade!</center>
            <div class="divFormEdit">
                <form method="POST">
                    <label for="editPhone">Telefone:</label>
                    <input type="number" name="editPhone" id="editPhone" placeholder="<?php echo htmlspecialchars($user["user_phone"])?>"><br>

                    <label for="editEmail">E-mail:</label>
                    <input type="email" name="editEmail" id="editEmail" placeholder="<?php echo htmlspecialchars($user["user_email"])?>"><br>

                    <label for="editPassw">Senha:</label>
                    <input type="password" name="editPassw" id="editPassw" placeholder="Nova Senha">
                    <i id="eye-editPassw" class="bi-eye-fill" onclick="hideShow('editPassw', 'eye-editPassw')"></i><br>
                    <button id="formEdit">Alterar</button>
                </form>     
            </div>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html> 