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
        $uri = $_SERVER['REQUEST_URI'];

        $id = null;
        if (preg_match('/\/tarefa\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
            $id = $matches[1];
        }

        switch ($method) {
            case 'POST':
                $this->inserirTarefa();
                break;
            case 'GET':
                $this->buscarTarefas($id);
                break;
            case 'PUT':
                if ($id) {
                    $this->atualizarTarefa($id);
                } else {
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['error' => 'ID da tarefa não fornecido']);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->deletarTarefa($id);
                } else {
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['error' => 'ID da tarefa não fornecido']);
                }
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
                echo json_encode(['error' => 'Método não permitido']);
                break;
        }
    }

    private function inserirTarefa()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $createdAt = isset($data['createdAt']) ? $data['createdAt'] : date('Y-m-d');
        $updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : date('Y-m-d');

        $status = Status::from($data['status']);

        $tarefa = new Tarefa(
            null,
            $data['titulo'],
            $data['descricao'],
            $status,
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

    private function buscarTarefas($id = null)
    {
        try {
            if ($id) {
                // Buscar uma tarefa específica
                $tarefa = $this->tarefaService->buscarTarefaPorIdService($id);
                if ($tarefa) {
                    header('Content-Type: application/json');
                    echo json_encode($this->convertTarefaToArray($tarefa));
                } else {
                    header('HTTP/1.1 404 Not Found');
                    echo json_encode(['error' => 'Tarefa não encontrada']);
                }
            } else {
                // Buscar todas as tarefas
                $tarefas = $this->tarefaService->buscarTarefasService();
                // Converter documentos BSON para arrays
                $tarefasArray = array_map([$this, 'convertTarefaToArray'], $tarefas);
                header('Content-Type: application/json');
                echo json_encode($tarefasArray);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function atualizarTarefa($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $status = Status::from($data['status']);

        $tarefa = new Tarefa(
            $id,
            $data['titulo'],
            $data['descricao'],
            $status,
            $data['dataVencimento'],
            '',
            date('Y-m-d') // Atualiza o campo updatedAt para a data atual
        );

        try {
            $updated = $this->tarefaService->atualizarTarefaService($tarefa);
            if ($updated) {
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

    private function deletarTarefa($id)
    {
        try {
            $deletedCount = $this->tarefaService->deletarTarefaService($id);
            if ($deletedCount > 0) {
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Tarefa deletada com sucesso!']);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(['error' => 'Tarefa não encontrada']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Erro interno do servidor: ' . $e->getMessage()]);
        }
    }

    private function convertTarefaToArray(Tarefa $tarefa): array
    {
        return [
            'id' => $tarefa->getId(),
            'titulo' => $tarefa->getTitulo(),
            'descricao' => $tarefa->getDescricao(),
            'status' => $tarefa->getStatus()->value,
            'dataVencimento' => $tarefa->getDataVencimento(),
            'createdAt' => $tarefa->getCreatedAt(),
            'updatedAt' => $tarefa->getUpdatedAt()
        ];
    }
}
