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

    /** Insere uma nova tarefa no bd usando o repository
     * @param Tarefa $tarefa A tarefa a ser inserida
     * @return ?string O ID da tarefa inserida
     */
    public function inserirTarefaService(Tarefa $tarefa): ?string
    {
        return $this->tarefaRepository->inserirTarefa($tarefa);
    }

    /** Busca todas as tarefas
     * @return Tarefa[] Um array de objetos Tarefa
     */
    public function buscarTarefasService(): array
    {
        return $this->tarefaRepository->buscarTarefas();
    }

    /** Busca uma tarefa em especifico
     * @param string $id busca uma tarefa em especifico
     * @return ?Tarefa uma entidade Tarefa
     */
    public function buscarTarefaPorIdService(string $id): ?Tarefa
    {
        return $this->tarefaRepository->buscarTarefaPorId($id);
    }

    /** Busca uma tarefa no bd usando o repository
     * @param Tarefa $tarefa A tarefa com os dados atualizados
     * @return $int O numero de documentos att no bd
     */
    public function atualizarTarefaService(Tarefa $tarefa): int
    {
        return $this->tarefaRepository->atualizarTarefa($tarefa);
    }

    /** Deleta uma tarefa no bd usando o repository
     * @param string $id O ID da tarefa a ser excluida
     * @return string Uma mensagem que indica o resultado da operação
     */
    public function deletarTarefaService(string $id): string
    {
        return $this->tarefaRepository->deletarTarefa($id);
    }
}
