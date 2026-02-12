const express = require('express');

const app = express();
const PORT = 3000;

app.use(express.json());

app.get('/', (req, res) => {
  res.json({ mensagem: "API funcionando!" });
});

app.get('/usuarios', (req, res) => {
    res.json([
        { id: 1, nome: "Vinícius" },
        { id: 2, nome: "Matheus" }
    ]);
});

app.post('/usuarios', (req, res) => {
    const novoUsuario = req.body;
    res.status(201).json({
        mensagem: "Usuário criado!",
        usuario: novoUsuario
    });
});

app.listen(PORT, () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
});
