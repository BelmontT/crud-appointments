<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/database/db.php");
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
                <form action="" method="POST">
                    <label for="appo_Personal">Personal:</label> <span style="color:red; font-size:10px;">*</span><br>
                    <select name="appo_Personal">
                        <option value=""></option>
                        <?php
                        $query = "SELECT account_id, user_name FROM users WHERE user_group = 2";
                        $result = mysqli_query($conn, $query);
                        
                        while($listUsers = mysqli_fetch_assoc($result)):
                        ?>
                        
                        <option value="<?php echo $listUsers['account_id']; ?>">
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
                        <option value=""></option>
                        <option value="hiit">HIIT</option>
                        <option value="strength">Força</option>
                        <option value="resistance">Resistência</option>
                        <option value="stretching">Alongamento</option>
                        <option value="multifunctional">Multifuncional</option>
                        <option value="cardiorespiratory">Cardiorrespiratório</option>
                    </select><br><br>

                    <button type="submit" name="appo_Create">Agendar</button>
                </form>
            </div>
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>