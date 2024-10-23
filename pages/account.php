<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');

    session_start();
    if(!isset($_SESSION["account_id"])){
        header("Location: login.php");
        exit();
    } else {
        $data = $_SESSION['account_id'];
        $query = ("SELECT * FROM users WHERE account_id = '$data'");
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user_id = $_POST["user_id"];
        $new_group = $_POST["user_group"];

        if(isset($user_id, $new_group) && $user_id !== "" && $new_group !== ""){
            $query = "UPDATE users SET user_group = '$new_group' WHERE user_id = '$user_id'";
            if(mysqli_query($conn, $query)){
                $message = "Cargo atribuído!";
                $messageClass = "boxSuccess";
            } else {
                $message = "Erro ao atribuir o cargo! " . mysqli_error($conn);
                $messageClass = "boxError";
            }
        } else {
            $message = "Selecione pelo menos um usuário e um cargo!";
            $messageClass = "boxWarning";
        }
    }
    $userGroup = $user["user_group"];
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
            <button onclick="history.back()" class="back"><i class="bi-reply" title="Voltar"></i></button>
            <a href="logout.php" class="logout"><i class="bi-power" title="Sair"></i></a>
            <img src="../layout/images/profile_account.png" class="image-profile">
            <center>Seja bem-vindo(a) a sua conta <?php echo htmlspecialchars($user["user_name"]);?>!</center><br>
            
            <center><caption>Dados Pessoais</caption></center>
            <table class="tableAccount">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($user["user_name"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_date_birth"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_email"]);?></td>
                        <td><?php echo htmlspecialchars($user["user_phone"]);?></td>
                        <td><a href="edit.php"><i class="bi-pencil" style="color:white;"></i></a></td>
                    </tr>
                </tbody>
            </table><br>
            
            <?php if($userGroup == $config["group"]["admin"]): ?>
                <center><caption>Gerenciar Treinos</caption></center>
                <table class="tableAppointments">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Treino</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Emanuel</td>
                            <td>01/10/2024</td>
                            <td>22:30</td>
                            <td>Perder KG</td>
                            <td>Pendente</td>
                            <td>
                                <a href="appointments/confirm.php"><i class="bi-check" style="color:green; font-size:20px;"></i></a>
                                <a href="appointments/cancel.php"><i class="bi-x" style="color:red; font-size:20px;"></i></a>
                                <a href="appointments/delete.php"><i class="bi-trash" style="color:white; font-size:15px;"></i></a>
                                <a href="appointments/edit.php"><i class="bi-pencil-square" style="color:white; font-size:15px; margin-left:4px;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table><br>

                <center><caption>Gerenciar Usuários</caption></center>
                <center><form action="" method="POST">
                    <select name="user_id">
                        <option value="">Usuário</option>
                        <?php
                            $query = "SELECT account_id, user_name FROM users WHERE user_group <= 2";
                            $result = mysqli_query($conn, $query);

                            while($listUsers = mysqli_fetch_assoc($result)):
                        ?>
                        <option value="<?php echo $listUsers['account_id']; ?>">
                            <?php echo htmlspecialchars($listUsers['user_name']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                
                    <select name="user_group">
                        <option value="">Cargo</option>
                        <option value="1">Usuário</option>
                        <option value="2">Personal</option>
                    </select>
                
                    <button type="submit">Atribuir</button>
                </center></form>

            <?php elseif($userGroup == $config["group"]["personal"]): ?>
                <center><caption>Gerenciar Treinos</caption></center>
                <table class="tableAppointments">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Treino</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Emanuel</td>
                            <td>01/10/2024</td>
                            <td>22:30</td>
                            <td>Perder KG</td>
                            <td>Pendente</td>
                            <td><a href="appointments/confirm.php"><i class="bi-check" style="color:green; font-size:20px;"></i></a>
                            <a href="appointments/cancel.php"><i class="bi-x" style="color:red; font-size:20px;"></i></a>
                            <a href="appointments/delete.php"><i class="bi-trash" style="color:white; font-size:15px;"></i></a></td>
                        </tr>
                    </tbody>
                </table>

            <?php else: ?>
                <center><caption>Seus Agendamentos</caption></center>
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
                            <td>Belmont</td>
                            <td>01/10/2024</td>
                            <td>22:30</td>
                            <td>Perder KG</td>
                            <td>Pendente</td>
                            <td><a href="download.php"><i class="bi-file-earmark-arrow-down" style="color:white;"></i></a></td>
                        </tr>
                    </tbody>
                </table><br>

                <center><a href="appointments/create.php"><button>Novo Agendamento</button></a></center>
            <?php endif; ?>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>