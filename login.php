<?php
session_start();
require 'conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($email) || empty($senha)) {
        $mensagem = "Preencha todos os campos!";
    } else {

        $stmt = $conn->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {

            $usuario = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario["senha"])) {

                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nome"] = $usuario["nome"];
                $_SESSION["usuario_tipo"] = $usuario["tipo"];

                header("Location: dashboard.php");
                exit();

            } else {
                $mensagem = "Senha incorreta!":
            }
        } else {
            $mensagem = "Usuário não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    
    <h2>Login</h2>

    <p style="color:red;"><?php echo $mensagem; ?></p>

    <form method="POST">

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha"><br><br>

        <button type="submit">Entrar</bytton>

</form>

</body>

</html>
