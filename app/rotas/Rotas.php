<?php

namespace app\rotas;

use app\controllers;
use app\helpers\Request;
use app\helpers\Uri;
use Exception;



class Rotas {


	const CONTROLLER_NAMESPACE ='app\\controllers';


	public static function load(string $controller, string $method, array $params = []) {
		try {
			//verifica se o controller existe
			$controllerNamespace = self::CONTROLLER_NAMESPACE . '\\' .$controller;
			if (!class_exists($controllerNamespace)) {
				throw new Exception("O controller {$controller} não existe.");
			}
			// verifica o método
			$controllerInstance = new $controllerNamespace;
			if (!method_exists($controllerNamespace, $method)) {
				throw new Exception("O método {$method} não existe no controller {$controller}.");
			}
		
			call_user_func_array([$controllerInstance, $method], $params);

		
		}
		catch (Exception $e ) {
			echo $e->getMessage();
		}

	}
	
	public static function routes(): array {
		return [
			'get' => [
				'/' => fn () => self::load('UsuariosController', 'index'),
				'/cadastrar' => fn () => self::load('UsuariosController', 'create'),
				'/tarefas' => fn () => self::load('TasksController', 'index'),
				'/editar' => fn () => self::load('TasksController', 'editar')
			],
			'post' => [
				'/' => fn () => self::load('UsuariosController', 'login'),
				'/cadastrar' => fn () => self::load('UsuariosController', 'create_user'),
				'/tarefas' => fn () => self::load('TasksController', 'create_tasks'),
				'/editar' => fn () => self::load('TasksController', 'update_task')
			],
			'delete' => [
				'/delete_task' => fn () => self::load('TasksController', 'delete_task') // Rota para deletar
			]
		];
	}

	
	public static function execute() {
		try {
			$routes = self::routes();
			$request = Request::get();
			$uri = Uri::get('path');
	
			if (!isset($routes[$request])) {
				throw new Exception('A rota não existe');
			}
	
			if (!array_key_exists($uri, $routes[$request])) {
				throw new Exception('A rota não existe');
			}
	
			$router = $routes[$request][$uri];
	
			if (!is_callable($router)) {
				throw new Exception("Rota {$uri} não é chamável");
			}
	
			// Executa o callable referenciado por $router!!!
			call_user_func($router);
	
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}