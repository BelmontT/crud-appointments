<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/database/db.php");

$message = "";
$messageClass = "";

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $colectDataAppointments = [];
    $user_id = $_SESSION['user_id'] ?? null;
    $account_id = $_SESSION['account_id'] ?? null;

    $queryUser = "SELECT * FROM users WHERE account_id = '$account_id' LIMIT 1";
    $resultUser = mysqli_query($conn, $queryUser);
        
    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $userData = mysqli_fetch_assoc($resultUser);
        $user_id = $userData['user_id'];
        $account_id = $userData['account_id'];
    } else {
        $message = "Não foi possível encontrar o ID do usuário. Tente novamente.";
        $messageClass = "boxError";
    }

    if (!$user_id || !$account_id) {
        $message = "Erro ao identificar o usuário ou a conta. Faça login novamente.";
        $messageClass = "boxError";
    } else {
        if (!empty($_POST["appo_Personal"])) {
            $appo_Personal = mysqli_real_escape_string($conn, $_POST["appo_Personal"]);
            $colectDataAppointments[] = "appo_Personal = '$appo_Personal'";
        }
        if (!empty($_POST["appo_Date"])) {
            $appo_Date = mysqli_real_escape_string($conn, $_POST["appo_Date"]);
            $colectDataAppointments[] = "appo_Date = '$appo_Date'";
        }
        if (!empty($_POST["appo_Time"])) {
            $appo_Time = $_POST["appo_Time"];
            if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $appo_Time)) {
                $appo_Time = mysqli_real_escape_string($conn, $appo_Time);
                $colectDataAppointments[] = "appo_Time = '$appo_Time'";
            } else {
                $message = "Horário inválido.";
                $messageClass = "boxError";
            }
        }        
        if (!empty($_POST["appo_Training"])) {
            $appo_Training = mysqli_real_escape_string($conn, $_POST["appo_Training"]);
            $colectDataAppointments[] = "appo_Training = '$appo_Training'";
        }

        if (!empty($colectDataAppointments)) {
            $query = "INSERT INTO `appointments` (`appointments_personal`, `appointments_date`, `appointments_hour`, `appointments_training`, `appointments_status`, `user_id`, `account_id`) VALUES ('$appo_Personal', '$appo_Date', '$appo_Time', '$appo_Training', 'Pendente', '$user_id', '$account_id')";
            $queryExecute = mysqli_query($conn, $query);

            if ($queryExecute) {
                $message = "Você acabou de realizar um agendamento, aguarde até que o instrutor aceite.";
                $messageClass = "boxSuccess";
            } else {
                $message = "Houve um erro no seu agendamento. " . mysqli_error($conn);
                $messageClass = "boxError";
            }
        } else {
            $message = "Você não preencheu todos os dados, volte e refaça o seu agendamento.";
            $messageClass = "boxWarning";
        }
    }
}
?>

<html lang="pt-BR">
    <head>
        <meta charSet="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Find your personal trainer and improve your training to achieve the shape you've always dreamed of.">
        <script type="text/javascript" src="../../layout/javascript/function.js"></script>
        <link rel="stylesheet" type="text/css" href="../../layout/css/style.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="icon" type="image/x-icon" href="../../favicon.ico">
        <title>Studio Vegas</title>
    </head>
    <header>
        <div class="header-content">
            <a href="../../index.html"><img src="../../layout/images/logo.png" title="Studio Vegas" class="image-logo"></a>
            <div class="profile-link profile-button">
                <i class="bi-person-circle"></i>
                <div class="profile-link-content">
                    <a href="../plans.php"><i class="bi-list"></i> Planos</a>
                    <a href="../login.php"><i class="bi-person-lines-fill"></i> Entrar</a>
                    <a href="../register.php"><i class="bi-person-plus-fill"></i> Registrar</a>
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
            <a href="../logout.php" class="logout"><i class="bi-power" title="Sair"></i></a>

            <div class="newAppointments">
                <form method="POST">
                    <label for="appo_Personal">Personal:</label> <span style="color:red; font-size:10px;">*</span><br>
                    <select name="appo_Personal">
                        <option value="">Selecione</option>
                        <?php
                        $query = "SELECT account_id, user_name FROM users WHERE user_group = 'Personal'";
                        $result = mysqli_query($conn, $query);
                        
                        while($listUsers = mysqli_fetch_assoc($result)):
                        ?>
                        
                        <option value="<?php echo htmlspecialchars($listUsers['user_name']); ?>">
                            <?php echo htmlspecialchars($listUsers['user_name']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select><br>

                    <label for="appo_Date">Escolha um dia:</label> <span style="color:red; font-size:10px;">*</span><br>
                    <input type="date" id="appo_Date" name="appo_Date" required><br>

                    <label for="appo_Time">Escolha um horário:</label> <span style="color:red; font-size:10px;">*</span><br>
                    <input type="time" id="appo_Time" name="appo_Time" required><br>

                    <label for="appo_Training">Tipo de Treino:</label> <span style="color:red; font-size:10px;">*</span><br>
                    <select name="appo_Training">
                        <option value="choose">Selecione</option>
                        <option value="hiit">HIIT</option>
                        <option value="strength">Força</option>
                        <option value="resistance">Resistência</option>
                        <option value="stretching">Alongamento</option>
                        <option value="multifunctional">Multifuncional</option>
                        <option value="cardiorespiratory">Cardiorrespiratório</option>
                    </select><br><br>

                    <button id="appo_Create" name="appo_Create">Agendar</button>
                </form>
            </div>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>