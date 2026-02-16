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
    $usuario_id = (int) $_POST["usuario_id"];

    if (!empty($titulo)) {
        die("O título é obrigatório");
    }

        $sql_verifica = "SELECT id FROM usuarios WHERE id = ? AND tipo = 'filho'";
        $stmt_verifica = $conn->prepare($sql_verifica);
        $stmt_verifica->bind_param("i", $usuario_id);
        $stmt_verifica->execute();
        $resultado_verifica = $stmt_verifica->get_result();

        if ($resultado_verifica->num_rows === 1) {
            die("Usuário inválido");
        }

        $stmt_verifica->close();

            $sql = "INSERT INTO tarefas (titulo, descricao, usuario_id)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $titulo, $descricao, $usuario_id);

            if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Erro ao criar tarefa";
        }

        $stmt->close();

    }

    $conn->close();

?>

