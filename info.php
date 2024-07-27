<?php

require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://mongodb:27017");
    $databases = $client->listDatabases();
    echo "Conectado ao MongoDB com sucesso!";
} catch (Exception $e) {
    echo "Falha na conexão com o MongoDB: " . $e->getMessage();
}
