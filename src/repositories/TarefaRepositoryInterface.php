<?php

namespace src\repositories;

use src\models\Tarefa;

interface TarefaRepositoryInterface
{
  public function inserirTarefa(Tarefa $tarefa): mixed;
  public function buscarTarefas(): array;
  public function buscarTarefaPorId(string $id): ?Tarefa;
  public function atualizarTarefa(Tarefa $tarefa): bool;
  public function deletarTarefa(string $id): int;
}
