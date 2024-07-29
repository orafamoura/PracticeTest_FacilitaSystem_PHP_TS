<?php

namespace src\repositories;

require_once __DIR__ . '/../models/Tarefa.php';
require_once __DIR__ . '/../models/enums/Status.php';
require_once(__DIR__ . '/TarefaRepositoryInterface.php');

use src\models\Tarefa;
use src\models\enums\Status;
use src\repositories\TarefaRepositoryInterface;
use MongoDB\Exception\Exception as MongoDBException;
use MongoDB\BSON\ObjectId;

class TarefaRepository implements TarefaRepositoryInterface
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    /** Insere uma nova tarefa no banco de dados
     * @param Tarefa $tarefa Objeto do tipo Tarefa inserido
     * @return Id tarefa inserido em caso de sucesso, ou null
     */
    public function inserirTarefa(Tarefa $tarefa): mixed
    {
        try {
            $tarefaData = [
                'titulo' => $tarefa->getTitulo(),
                'descricao' => $tarefa->getDescricao(),
                'status' => $tarefa->getStatus()->value,
                'dataVencimento' => $tarefa->getDataVencimento(),
                'createdAt' => $tarefa->getCreatedAt(),
                'updatedAt' => $tarefa->getUpdatedAt()
            ];

            $result = $this->collection->insertOne($tarefaData);
            return $result->getInsertedId();
        } catch (MongoDBException $e) {
            return null;
        }
    }
    /**busca todas as tarefas
     * @return Array com todas as tarefas 
     */
    public function buscarTarefas(): array
    {
        $result = $this->collection->find();
        return array_map([$this, 'mapToTarefa'], $result->toArray());
    }

    /**Busca uma tarefa no banco de dados pelo seu ID
     * @param string $id O ID da tarefa a ser buscada no banco de dados
     * @return ?Tarefa A instância da entidade `Tarefa`
     */
    public function buscarTarefaPorId(string $id): ?Tarefa
    {
        $result = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        return $result ? $this->mapToTarefa($result) : null;
    }

    /**Atualiza todas as tarefas
     * @param Tarefa $tarefa Objeto do tipo tarefa atualizado
     * @return Tarefa  atualizada em caso de sucesso
     */
    public function atualizarTarefa(Tarefa $tarefa): bool
    {
        try {
            $filter = ['_id' => new \MongoDB\BSON\ObjectId($tarefa->getId())];
            $formattedDate = date('Y-m-d');

            $update = ['$set' => [
                'titulo' => $tarefa->getTitulo(),
                'descricao' => $tarefa->getDescricao(),
                'status' => $tarefa->getStatus()->value,
                'updatedAt' => $formattedDate
            ]];

            $result = $this->collection->updateOne($filter, $update);
            return $result->getModifiedCount() > 0;
        } catch (MongoDBException $e) {
            return false;
        }
    }

    /**Deleta uma tarefa existente no banco de dados
     * @param string $id O ID da tarefa a ser deletada
     * @return int O numero de documentos deletados.
     */
    public function deletarTarefa(string $id): int
    {
        try {
            $filter = ['_id' => new ObjectId($id)];
            $result = $this->collection->deleteOne($filter);
            return $result->getDeletedCount();
        } catch (MongoDBException $e) {
            error_log('Erro ao deletar tarefa: ' . $e->getMessage());
            return 0;
        }
    }

    /**Mapeia um doc BSON para uma instancia da entidade Tarefa
     * @param $document O documento BSON a ser mapeado
     * @return Tarefa A instância da entidade `Tarefa` criada a partir dos dados do documento BSON.
     */
    private function mapToTarefa($document): Tarefa
    {
        return new Tarefa(
            (string)$document->_id,
            $document->titulo,
            $document->descricao,
            Status::from($document->status),
            $document->dataVencimento,
            $document->createdAt,
            $document->updatedAt
        );
    }
}
