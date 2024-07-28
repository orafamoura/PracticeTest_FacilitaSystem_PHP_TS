<?php 
require '/var/www/html/vendor/autoload.php';

use MongoDB\Client;
use src\repositories\TarefaRepository;
use src\services\TarefaService;
use src\controllers\TarefaController;

// Conectar ao MongoDB
$client = new Client('mongodb://mongodb:27017');
$collection = $client->selectCollection('teste_pratico_facilita_system', 'tarefas');
$tarefaRepository = new TarefaRepository($collection);
$tarefaService = new TarefaService($tarefaRepository);
$tarefaController = new TarefaController($tarefaService);

$tarefaController->handleRequest();
