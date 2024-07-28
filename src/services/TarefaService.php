<?php
namespace src\services;

use src\repositories\TarefaRepositoryInterface;
use src\models\Tarefa;

class TarefaService
{

    private TarefaRepositoryInterface $tarefaRepository;

    public function __construct(TarefaRepositoryInterface $tarefaRepository)
    {
        $this->tarefaRepository = $tarefaRepository;
    }

    public function inserirTarefaService(Tarefa $tarefa): void
    {
       $this->tarefaRepository->inserirTarefa($tarefa);
    }

    public function buscarTarefasService(): array
    {
        return $this->tarefaRepository->buscarTarefas();
    }

    public function atualizarTarefaService(Tarefa $tarefa): int
    {
        return $this->tarefaRepository->atualizarTarefa($tarefa);
    }

    public function deletarTarefaService(string $id): int
    {
        return $this->tarefaRepository->deletarTarefa($id);
    }
}