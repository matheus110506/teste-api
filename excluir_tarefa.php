<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["usuario_tipo"] !== "pai") {
    die("Apenas pais podem excluir tarefas");
}

if (isset($_GET["id"])) {
    
    $tarefa_id = (int) $_GET["id"];
    $usuario_id = $_SESSION["usuario_id"];

    $sql = "DELETE FROM tarefas
            WHERE id = ? AND usuario_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tarefa_id, $usuario_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
