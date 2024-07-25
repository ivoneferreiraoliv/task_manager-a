<?php

namespace app\controllers;


class TasksController{
	public function index(){
		require __DIR__ . "/../views/tasks/areaTarefas.php";
	}

	public function create_tasks(){
		session_start();
	
		if(isset($_SESSION['usuario_id'])) {
			$user_id = $_SESSION['usuario_id']; // Recupera o ID do usuário da sessão
	
			
			$validate = Validate([
				'titulo' => 's',
				'descricao'=> 's',
				'data_limite'=> 's',
				'status'=> 's',
			]);
	
			
			$tarefa_id = create_tasks("tasks", $validate, $user_id);

            if ($tarefa_id) {
                // Obter os dados da tarefa recém-criada
                $tarefa = find("tasks", "id", $tarefa_id);

                $response = [];
                // Preparar a resposta
                $response = array(
                    'id' => $tarefa['id'],
                    'titulo' => $tarefa['titulo'],
                    'descricao' => $tarefa['descricao'],
                    'data_limite' => $tarefa['data_limite'],
                    'status' => $tarefa['status']
                );

                if ($tarefa_id) {
                    header('Content-Type: application/json');
                    $response = ['success' => true, 'message' => 'Tarefa adicionada com sucesso!'];
                } else {
                    header('Content-Type: application/json');
                    $response = ['success' => false, 'message' => 'Erro ao adicionar a tarefa.'];
                }
            
                
                echo json_encode($response);
                exit(); 
            }}}
	public function editar(){
		require __DIR__ . "/../views/tasks/editar_task.php";
	}


    public function update_task(){
        
        $id = $_POST['id'] ?? null;
        if ($id === null) {
            echo "ID da tarefa não fornecido.";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $validate = Validate([
            'titulo' => 's',
            'descricao'=> 's',
            'data_limite'=> 's',
            'status'=> 's',
        ]);
    
        if(update_task_db("tasks", $validate, $id)){
            echo "Tarefa atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar tarefa.";
        }
        var_dump(update_task_db('tasks', $validate, $id));
        exit();
        
    }}
    public function delete_task() {
        $input = json_decode(file_get_contents('php://input'), true); // Lê a entrada JSON
        $taskId = $input['id'];
    
        if (delete_task_db("tasks", $input, $taskId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir a tarefa.']);
        }
    }}