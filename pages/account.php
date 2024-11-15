<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');

    session_start();
    if(!isset($_SESSION["account_id"])){
        header("Location: login.php");
        exit();
    }
    
    $data = $_SESSION['account_id'];
    $query = ("SELECT * FROM users WHERE account_id = '$data'");
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
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
            <a href="logout.php" class="logout"><i class="bi-power" title="Sair"></i></a>
            <img src="../layout/images/profile_account.png" class="image-profile">
            <center>Seja bem-vindo(a) a sua conta <?php echo htmlspecialchars($user["user_name"]);?>!</center><br>
            
            <center><caption>Dados Pessoais</caption></center>
            <table class="tableAccount">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($user["user_name"]);?></td>
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
                            <th>Personal</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Treino</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php
                            $appointments = "SELECT a.*, u.user_name AS student_name, p.user_name AS personal_name FROM appointments a LEFT JOIN users u ON a.user_id = u.user_id LEFT JOIN users p ON a.appointments_personal = p.user_name";
                            $queryExecute = mysqli_query($conn, $appointments);

                            if ($queryExecute && mysqli_num_rows($queryExecute) > 0) {
                                while ($row = mysqli_fetch_assoc($queryExecute)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["personal_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_date"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_hour"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_training"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_status"]) . "</td>";
                                    echo "<td>
                                            <a href='appointments/confirm.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-check' style='color:green; font-size:20px;'></i>
                                            </a>
                                            <a href='appointments/cancel.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-x' style='color:red; font-size:20px;'></i>
                                            </a>
                                            <a href='appointments/delete.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-trash' style='color:white; font-size:15px;'></i>
                                            </a>
                                            <a href='appointments/edit.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-pencil-square' style='color:white; font-size:15px; margin-left:4px;'></i>
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>Nenhum agendamento encontrado.</td></tr>";
                            }
                            ?>
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
                        <option value="Usuario">Usuário</option>
                        <option value="Personal">Personal</option>
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

                        <?php
                            $appointments = "SELECT a.*, u.user_name AS student_name FROM appointments a LEFT JOIN users u ON a.user_id = u.user_id WHERE a.appointments_personal = '{$user['user_name']}'";
                            $queryExecute = mysqli_query($conn, $appointments);
                            if ($queryExecute && mysqli_num_rows($queryExecute) > 0) {
                                while ($row = mysqli_fetch_assoc($queryExecute)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_date"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_hour"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_training"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_status"]) . "</td>";
                                    echo "<td>
                                            <a href='appointments/confirm.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-check' style='color:green; font-size:20px;'></i>
                                            </a>
                                            <a href='appointments/cancel.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-x' style='color:red; font-size:20px;'></i>
                                            </a>
                                            <a href='appointments/edit.php?id=" . $row["appointments_id"] . "'>
                                                <i class='bi-pencil-square' style='color:white; font-size:15px; margin-left:4px;'></i>
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                             else {
                                echo "<tr><td colspan='5'>Nenhum agendamento encontrado.</td></tr>";
                            }
                        ?>
                    </thead>
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
                        </tr>

                        <?php
                            $appointments = "SELECT * FROM appointments WHERE user_id = '$user[user_id]'";
                            $queryExecute = mysqli_query($conn, $appointments);
                            if ($queryExecute && mysqli_num_rows($queryExecute) > 0) {
                                while ($row = mysqli_fetch_assoc($queryExecute)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["appointments_personal"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_date"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_hour"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_training"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["appointments_status"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Nenhum agendamento encontrado.</td></tr>";
                            }
                        ?>
                    </thead>
                </table><br>

                <center><a href="appointments/create.php"><button>Novo Agendamento</button></a></center>
            <?php endif; ?>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>