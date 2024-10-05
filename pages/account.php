<?php
    require("../database/db.php");
    $message = "";
    $messageClass = "";

    session_start();
    if(!isset($_SESSION["account_id"])){
        header("Location: login.php");
        exit();
    } else {
        $data = $_SESSION['account_id'];
        $query = ("SELECT * FROM users WHERE account_id = '$data'");
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        $message = "Login efetuado!";
        $messageClass = "boxSuccess";
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
            <a href="logout.php" class="logout">Sair</a>
            <img src="../layout/images/profile_account.png" class="image-profile">
            <center>Seja bem-vindo(a) a sua conta <?php echo htmlspecialchars($user["user_name"]);?>!</center><br>
            <center><caption>Dados Pessoais</caption></center>
            <table class="tableAccount">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($user["user_group"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_name"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_date_birth"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_email"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_phone"]);?></td>
                        <td><a href="edit.php"><i class="bi-wrench" style="color:white;"></i></a></td>
                    </tr>
                </tbody>
            </table><br>

            <center><caption>Agendamentos</caption></center>
            <table class="tableAppointments">
                <thead>
                    <tr>
                        <th>Personal</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Treino</th>
                        <th>Status</th>
                        <th>Baixar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Marcola</td>
                        <td>01/10/2024</td>
                        <td>22:30</td>
                        <td>Perder KG</td>
                        <td>Pendente</td>
                        <td><a href="download.php"><i class="bi-file-earmark-arrow-down" style="color:white;"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>