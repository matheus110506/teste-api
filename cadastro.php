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
        <title>Cadastro</title>
    </head>
    <body>

    <h2>Cadastro de Usuário</h2>

    <p style="color:red;"><?php echo $mensagem; ?></p>

    <form method="POST">

        <label>Nome:</label><br>
        <input type="text" name="nome"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha"><br><br>

        <label>Tipo:</label><br>
        <select name="tipo">
            <option value="mae">Mãe</option>
            <option value="filho">Filho</option>
        </select><br><br>

        <button type="submit">Cadastrar</button><br>
        <a href="login.php" class="botao">Já tenho uma conta</a>
    </form>

</body>

</html>
