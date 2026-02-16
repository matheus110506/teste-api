<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["usuario_tipo"] !== "mae") {
    die("Apenas pais podem excluir tarefas");
}

if (isset($_GET["id"])) {
    
    $tarefa_id = (int) $_GET["id"];

    $sql = "DELETE FROM tarefas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tarefa_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
