<?php 
require '/var/www/html/vendor/autoload.php';

use MongoDB\Client;
use src\repositories\TarefaRepository;
use src\services\TarefaService;
use src\controllers\TarefaController;

// Conectar ao MongoDB
try {
  $mongoUri = getenv('MONGO_URI') ?: 'mongodb://mongodb:27017';
  $client = new Client($mongoUri);
  $client->selectDatabase('teste_pratico_facilita_system')->command(['ping' => 1]); // Testa a conexão
} catch (Exception $e) {
  die('Erro ao conectar ao MongoDB: ' . $e->getMessage());
}

$collection = $client->selectCollection('teste_pratico_facilita_system', 'tarefas');
$tarefaRepository = new TarefaRepository($collection);
$tarefaService = new TarefaService($tarefaRepository);
$tarefaController = new TarefaController($tarefaService);

//Manipula a API
$tarefaController->handleRequest();
