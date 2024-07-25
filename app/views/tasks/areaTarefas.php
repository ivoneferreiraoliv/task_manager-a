<?php 

include(__DIR__ . '/../partials/header.php');
session_start(); // Garante que a sessão foi iniciada
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para a página de login se o usuário não estiver logado
    header('Location: /');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Tasks</title>
</head>
<body>
    <form action="/tarefas" method="POST" id="task-form">
        <input type="hidden" name="id" value=""> <!-- Campo oculto para armazenar o ID da tarefa -->
        <input type="text" id="task-title" placeholder="Título da Tarefa" name="titulo" required>
        <textarea id="task-desc" placeholder="Descrição da Tarefa" name="descricao" required></textarea>
        <input type="date" id="task-deadline" name="data_limite" required>
        <select id="task-status" name="status" required>
            <option value="Em andamento">Em andamento</option>
            <option value="Concluída">Concluída</option>
        </select>
        <button type="submit">Salvar Tarefa</button> <!-- Atualizado para refletir a ação de salvar (adicionar ou atualizar) -->
    </form>

    <div id="tasks-container">
        <table id="tarefas-table" class="task-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prazo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tasks = getTasksByUserId('tasks', $_SESSION['usuario_id']);
                    foreach ($tasks as $task) {
                        echo "<tr data-id='" . $task['id'] . "'>";
                        echo "<td>" . htmlspecialchars($task['titulo']) . "</td>";
                        echo "<td>" . htmlspecialchars($task['descricao']) . "</td>";
                        echo "<td>" . htmlspecialchars($task['data_limite']) . "</td>";
                        echo "<td>" . htmlspecialchars($task['status']) . "</td>";
                        echo "<td class='task-buttons'>";
                        echo "<a href='/editar?id=" . htmlspecialchars($task['id']) . "' class='btn btn-edit'><i class='fas fa-edit'></i></a>";
                        echo "<form method='post' class='inline-form' onsubmit='return confirm(\"Tem certeza que deseja excluir esta tarefa?\");'>";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($task['id']) . "'>";
                        echo "<button type='button' class='delete-task-btn btn btn-delete' data-task-id='" . htmlspecialchars($task['id']) . "'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php include(__DIR__ . '/../partials/footer.php'); ?>
</body>
</html>
