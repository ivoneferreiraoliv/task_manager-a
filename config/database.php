<?php

define("DB_HOST", "localhost");
define("DB_NAME", "task_manager");
define("DB_USER", "root");
define("DB_PASS", "senha123");
define("DB_DRIVER", "mysql");

function getConnection(): PDO
{
    $dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Conexão falhou: ' . $e->getMessage();
        exit;
    }
}


function create_user($table, $fields){

    if(!is_array($fields)){
        if(is_object($fields)){
            $fields = get_object_vars($fields);
        } else {
            $fields = array($fields);
        }
        

    }

    
    $sql = "INSERT INTO {$table}";


    $sql .= "(".implode(",", array_keys($fields)).")";
    $sql .= "VALUES(". ":" .implode(",:", array_keys($fields)).")";

    $pdo = getConnection();
    
    $insert = $pdo->prepare($sql);

    
    
    $insert->execute($fields);

}



//tarefas:



function create_tasks($table, $fields, $user_id){
    if(!is_array($fields)){
        if(is_object($fields)){
            $fields = get_object_vars($fields);
        } else {
            $fields = array($fields);
        }
        

    }

    $fields['usuario_id'] = $user_id;

    
    $sql = "INSERT INTO {$table}";


    $sql .= "(".implode(",", array_keys($fields)).")";
    $sql .= "VALUES(". ":" .implode(",:", array_keys($fields)).")";

    $pdo = getConnection();
    
    $insert = $pdo->prepare($sql);

    
    
    $insert->execute($fields);

    return $pdo->lastInsertId();

}


    function find($table, $field, $value){
        $pdo = getConnection();
        $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);    
        $sql = "SELECT * FROM {$table} WHERE {$field} = :{$field}";
        $find = $pdo->prepare($sql);
        // Corrigido para usar o mesmo nome do placeholder definido na consulta SQL
        $find->bindValue(":{$field}", $value);
        $find->execute();
        return $find->fetch();

}

function getTasksByUserId($table, $user_id) {
	$pdo = getConnection();
	// Prepara a consulta SQL para selecionar todas as tarefas associadas ao ID do usuário
	$sql = "SELECT * FROM {$table} WHERE usuario_id = :user_id";
	$list_tasks = $pdo->prepare($sql);
	// Vincula o ID do usuário à consulta
	$list_tasks->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	// Executa a consulta
	$list_tasks->execute();
	// Retorna os resultados
	return $list_tasks->fetchAll(PDO::FETCH_ASSOC);
}

function all_tasks($table){
    $pdo = getConnection();
            
    $sql = "SELECT * FROM {$table}";
    $list = $pdo->query($sql);

    $list->execute();

    return $list->fetchAll();
}

function update_task_db($table, $fields, $where){
    if(!is_array($fields)){
        if(is_object($fields)){
            $fields = get_object_vars($fields);
        } else {
            $fields = array($fields);
        }
    }

    $pdo = getConnection();

    if (!isset($where[0], $where[1])) {
        throw new InvalidArgumentException("Parâmetros de condição WHERE estão faltando.");
    }

    $sql = "UPDATE {$table} SET ";
    $setParts = [];
    foreach ($fields as $field => $value) {
        $setParts[] = "{$field} = :{$field}";
    }
    $sql .= implode(", ", $setParts);
    $sql .= " WHERE {$where[0]} = :whereValue";

    $data = array_merge($fields, ['whereValue' => $where[1]]);

    $update = $pdo->prepare($sql);
    $update->execute($data);

    return $update->rowCount();
}

function delete_task_db($table, $field, $value){
    if (isset($_POST['id'])) {
        $taskId = $_POST['id'];
    
    $pdo= getConnection();

    $sql = "DELETE FROM {$table} WHERE {$field} = :value";

    $delete = $pdo->prepare($sql);
    $delete->bindParam(':value', $value);

    return $delete->execute()) {
       
}
}




