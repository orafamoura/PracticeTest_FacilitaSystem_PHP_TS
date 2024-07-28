<?php

namespace src\repositories;

use src\models\Tarefa;

interface TarefaRepositoryInterface
{
  public function inserirTarefa(Tarefa $tarefa): mixed;
  public function buscarTarefas(): array;
  public function atualizarTarefa(Tarefa $tarefa): int;
  public function deletarTarefa($id): int;
}