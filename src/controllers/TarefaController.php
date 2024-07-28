<?php

namespace src\controllers;

use src\models\Tarefa;
use src\models\enums\Status;
use src\services\TarefaService;
use Exception;

class TarefaController
{
    private TarefaService $tarefaService;

    public function __construct(TarefaService $tarefaService)
    {
        $this->tarefaService = $tarefaService;
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $this->inserirTarefa();
                break;
            case 'GET':
                $this->buscarTarefas();
                break;
            case 'PUT':
                $this->atualizarTarefa();
                break;
            case 'DELETE':
                $this->deletarTarefa();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
                break;
        }
    }

    private function inserirTarefa()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $createdAt = isset($data['createdAt']) ? $data['createdAt'] : date('Y-m-d');
        $updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : date('Y-m-d');

        $tarefa = new Tarefa(
            null, 
            $data['titulo'],
            $data['descricao'],
            Status::NaoIniciada,
            $data['dataVencimento'],
            $createdAt,
            $updatedAt
        );

        try {
            $this->tarefaService->inserirTarefaService($tarefa);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Tarefa inserida com sucesso!']);
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function buscarTarefas()
    {
        $tarefas = $this->tarefaService->buscarTarefasService();
        header('Content-Type: application/json');
        echo json_encode($tarefas);
    }

    private function atualizarTarefa()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $tarefa = new Tarefa(
            $data['_id'],
            $data['titulo'],
            $data['descricao'],
            Status::NaoIniciada
        );

        try {
            $updatedCount = $this->tarefaService->atualizarTarefaService($tarefa);
            if ($updatedCount > 0) {
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Tarefa atualizada com sucesso!']);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(['error' => 'Tarefa não encontrada ou não atualizada']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function deletarTarefa()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $deletedCount = $this->tarefaService->deletarTarefaService($data['_id']);
            if ($deletedCount > 0) {
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Tarefa deletada com sucesso!']);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(['error' => 'Tarefa não encontrada']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
