<?php
namespace app\views\tasks;
include(__DIR__ . '/../partials/header.php');
// Verifica se o índice 'id' está definido em $_GET e não é nulo
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    echo "ID da tarefa não fornecido.";
    exit; // Encerra a execução do script
}

// Supondo que a função 'find' esteja corretamente definida em outro lugar
$tasks = find("tasks", "id", $_GET["id"]);

// Verifica se a tarefa foi encontrada
if (!$tasks) {
    echo "Tarefa não encontrada.";
    exit; // Encerra a execução do script
}
?>
<body>
<form action="/tarefas" method="POST" id="task-form">
    <input type="hidden" id="task-id" name="id">
    <input type="text" id="task-title" placeholder="Título da Tarefa" name="titulo" required>
    <textarea id="task-desc" placeholder="Descrição da Tarefa" name="descricao" required></textarea>
    <input type="date" id="task-deadline" name="data_limite" required>
    <select id="task-status" name="status" required>
        <option value="Em andamento">Em andamento</option>
        <option value="Concluída">Concluída</option>
    </select>
    <button type="submit">Salvar Tarefa</button>
</form>
	<?php include(__DIR__ . '/../partials/footer.php'); ?>
</body>
</body>