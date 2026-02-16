<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];


if ($_SESSION["usuario_tipo"] == "filho") {

    $sql = "SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY data_criacao DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);

}   else {

    $sql = "SELECT tarefas.*, usuarios.nome
            FROM tarefas
            JOIN usuarios ON tarefas.usuario_id = usuarios.id
            WHERE usuarios.tipo = 'filho'
            ORDER BY data_criacao DESC";

    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<h2>Bem vindo, <?php echo $_SESSION["usuario_nome"]; ?>!</h2>
<a href="logout.php">Sair</a>

<?php if ($_SESSION["usuario_tipo"] == "mae") {

    $sql_filhos = "SELECT id, nome FROM usuarios WHERE tipo = 'filho'";
    $resultado_filhos = $conn->query($sql_filhos);
?>

<h2>Nova Tarefa</h2>
<form method="POST" action="criar_tarefa.php">

    <input type="text" name="titulo" placeholder="Título da tarefa" required>
    <textarea name="descricao" placeholder="Descrição"></textarea>

    <label>Para qual filho?</label>
    <select name="usuario_id" required>
        <?php while ($filho = $resultado_filhos->fetch_assoc()): ?>
            <option value="<?php echo $filho["id"]; ?>">
                <?php echo $filho["nome"]; ?>
        </option>
    <?php endwhile; ?>
        </select>

        <button type="submit">Adicionar</button>
        </form>

        <?php } ?>

        <hr>

        <h2>Tarefas</h2>

        <?php while ($tarefa = $resultado->fetch_assoc()): ?>

            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

            <?php if ($_SESSION["usuario_tipo"] == "mae"): ?>
                <strong>Filho:</strong> <?php echo $tarefa["nome"]; ?><br>
            <?php endif; ?>

            <strong><?php echo $tarefa["titulo"]; ?></strong><br>
            <?php echo $tarefa["descricao"]; ?><br>
            Status: <?php echo $tarefa["status"]; ?><br>

            <?php if (
                $tarefa["status"] == "pendente"
                && $_SESSION["usuario_tipo"] == "filho"
            ): ?>
                <a href="concluir_tarefa.php?id=<?php echo $tarefa["id"]; ?>">
                    Marcar como concluída
                </a>
            <?php endif; ?>

            <?php if ($_SESSION["usuario_tipo"] == "mae"): ?>
                <br>
                <a href="excluir_tarefa.php?id=<?php echo $tarefa["id"]; ?>">
                    Excluir
            </a>
        <?php endif; ?>

        </div>
    <?php endwhile; ?>
    
    <?php
    $stmt->close();
    $conn->close();
?>

