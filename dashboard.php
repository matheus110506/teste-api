<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

$sql = "SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY data_criacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<h2>Bem vindo, <?php echo $_SESSION["usuario_nome"]; ?>!</h2>
<a href="logout.php">Sair</a>

<?php if ($_SESSION["usuario_tipo"] == "mae"): ?>
<h2>Nova Tarefa</h2>
<form method="POST" action="criar_tarefa.php">
    <input type="text" name="titulo" placeholder="Título da tarefa" required>
    <textarea name="descricao" placeholder="Descrição"></textarea>
    <button type="submit">Adicionar</button>
</form>
<?php endif; ?>

<hr>

<h2>Minhas Tarefas</h2>

<?php while ($tarefa = $resultado->fetch_assoc()): ?>

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?php echo $tarefa["titulo"]; ?></strong><br>
        <?php echo $tarefa["descricao"]; ?><br>
        Status: <?php echo $tarefa["status"]; ?><br>

        <?php if ($tarefa["status"] == "pendente"): ?>
            <a href="concluir_tarefa.php?id=<?php echo $tarefa["id"]; ?>">
                Marcar como concluída
        </a>
    <?php endif; ?>
    </div>

<?php endwhile; ?>

<?php
$stmt->close();
$conn->close();
?>

