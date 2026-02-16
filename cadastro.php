<?php
require 'conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];
    $tipo = $_POST["tipo"];

    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        $mensagem = "Preencha todos os campos!";
    } else {

        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = "Email já cadastrado!";
        } else {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $tipo);

        if($stmt->execute()) {
            $mensagem = "Usuário castrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar.";
        }

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">

    <h2>Criar Conta</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="nome" placeholder="Nome" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <select name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="mae">Mãe</option>
            <option value="filho">Filho</option>
        </select>

        <button type="submit">Cadastrar</button>

    </form>

    <div class="auth-link">
        <a href="login.php">Já tenho uma conta</a>
    </div>

</div>

</body>
</html>
