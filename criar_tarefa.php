<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["usuario_tipo"] !== "mae") {
    die("Apenas pais podem criar tarefas");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = trim($_POST["titulo"]);
    $descricao = trim($_POST["descricao"]);
    $usuario_id = $_SESSION["usuario_id"];

    if (!empty($titulo)) {

        $sql = "INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $titulo, $descricao, $usuario_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        }   else {
            echo "Erro ao criar tarefa";
        }

        $stmt->close();
        }   else {
            echo "O título é obrigatório";
        }
    }

$conn->close();
?>
