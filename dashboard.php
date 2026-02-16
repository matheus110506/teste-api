<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Bem vindo, <?php echo $_SESSION["usuario_nome"]; ?>!</h2>

<a href="logout.php">Sair</a>

<h2>Nova Tarefa</h2>

<form method="POST" action="criar_tarefa.php">
    <input type="text" name="titulo" placeholder="Título da tarefa" required>
    <textarea name="descricao" placeholder="Descrição"></textarea>
    <button type="submit">Adicionar</button>
</form>
