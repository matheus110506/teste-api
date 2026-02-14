const express = require('express');

const app = express();
const PORT = 3000;

app.use(express.json());

let usuarios = [
    { id: 1, nome: "Vinícius" },
    { id: 2, nome: "Matheus" }
];

let proximoId = 3;

app.get('/', (red, res) => {
    res.json({ mensagem: "API funcionando!" });
});

app.get('/usuarios', (req, res) => {
    res.json(usuarios);
});

app.post('/usuarios', (req, res) => {
    const { nome } = req.body;

    if (!nome) {
        return res.status(400).json({ erro: "Nome é obrigatório" });
    }

    const novoUsuario = {
        id: proximoId++,
        nome
    };

    usuarios.push(novoUsuario);

    res.status(201).json({
        mensagem: "Usuário criado!",
        usuario: novoUsuario
    });
});

app.listen(PORT, () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
});
app.listen(PORT, () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
});

