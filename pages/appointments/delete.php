<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/db.php');
session_start();

if (!isset($_SESSION["account_id"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $appointmentId = intval($_GET['id']);
    $query = "DELETE FROM appointments WHERE appointments_id = $appointmentId";
    if (mysqli_query($conn, $query)) {
        $message = "Agendamento deletado com sucesso!";
        $messageClass = "boxSuccess";
        header("Location: ../account.php");
    } else {
        $message = "Erro ao deletar o agendamento: " . mysqli_error($conn);
        $messageClass = "boxError";
    }
} else {
    $message = "ID do agendamento não fornecido!";
    $messageClass = "boxWarning";
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
        </div>
    </body>
    <div class="footer">
        © Todos os direitos reservados.
    </div>
</html>