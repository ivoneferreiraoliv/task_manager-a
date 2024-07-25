//redirecionamento para a página de cadastro 
document.addEventListener('DOMContentLoaded', function() {
    var registerBtn = document.getElementById('registerBtn');
    if (registerBtn) {
        registerBtn.addEventListener('click', function() {
            window.location.href = '/cadastrar';
        });
    }
});


$(document).ready(function() {
    $('#task-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var taskId = $('#task-form').find('input[name="id"]').val(); // Obtém o ID da tarefa, se existir

        if (taskId) {
            updateTask(formData, taskId);
        } else {
            addTask(formData);
        }
    });

    function addTask(formData) {
        $.ajax({
            url: '/tarefas',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert("Tarefa adicionada com sucesso!");
                location.reload(); // Recarrega a página para exibir a nova tarefa
            },
            error: function(xhr, status, error) {
                alert("Erro ao adicionar tarefa: " + error);
            }
        });
    }

    function updateTask(formData, taskId) {
        $.ajax({
            url: '/editar',
            type: 'POST',
            data: formData + '&id=' + taskId, // Adiciona o ID da tarefa ao formulário
            success: function(response) {
                alert("Tarefa atualizada com sucesso!");
                location.reload(); // Recarrega a página para exibir a tarefa atualizada
            },
            error: function(xhr, status, error) {
                alert("Erro ao atualizar tarefa: " + error);
            }
        });
    }

    $('.delete-task-btn').on('click', function(e) {
        e.preventDefault();

        var taskId = $(this).data('task-id'); // Obtém o ID da tarefa
        var row = $(this).closest('tr'); // Encontra a linha da tabela mais próxima

        if (confirm("Tem certeza que deseja excluir esta tarefa?")) {
            $.ajax({
                url: '/delete_task', // Altere esta URL conforme necessário
                type: 'POST',
                data: { id: taskId },
                success: function(response) {
                    var data = JSON.parse(response); // Analisa a resposta JSON
                    if (data.success) {
                        row.remove(); // Remove a linha da tabela do DOM
                    } else {
                        alert("Não foi possível excluir a tarefa.");
                    }
                },
                error: function() {
                    alert("Erro ao enviar a solicitação.");
                }
            });
        }
    });
});
