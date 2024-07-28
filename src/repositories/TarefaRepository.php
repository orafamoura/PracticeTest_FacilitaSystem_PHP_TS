<?php 

namespace src\repositories;

require_once __DIR__ . '/../models/Tarefa.php';
require_once __DIR__ . '/../models/enums/Status.php';
require_once(__DIR__ . '/TarefaRepositoryInterface.php');

use src\models\Tarefa;
use src\repositories\TarefaRepositoryInterface;
use MongoDB\Exception\Exception as MongoDBException;
use MongoDB\BSON\ObjectId;

class TarefaRepository implements TarefaRepositoryInterface
{
    private $collection;

    public function __construct($collection){
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
        } catch (MongoDBException $e){
            return null;
        }
    }
    /**busca todas as tarefas
     * @return Array com todas as tarefas 
     */
    public function buscarTarefas(): array
    {
        try {
            $tarefas = $this->collection->find([]);
            $tarefasArray = [];
            foreach ($tarefas as $tarefa) {
                $tarefasArray[] = $tarefa;
            }
            return $tarefasArray;
        } catch (MongoDBException $e) {
            return [];
        }
    }
    /**Atualiza todas as tarefas
     * @param Tarefa $tarefa Objeto do tipo tarefa atualizado
     * @return Tarefa  atualizada em caso de sucesso
     */
    public function atualizarTarefa(Tarefa $tarefa): int
    {
        try{
            $filter = ['_id' => new \MongoDB\BSON\ObjectId($tarefa->getId())];
            $update = ['$set' => [
                'titulo' => $tarefa->getTitulo(),
                'descricao' => $tarefa->getDescricao(),
                'status' => $tarefa->getStatus()->value,
            ],
                '$currentDate' => ['updatedAt' => true]
            ];

            $result = $this->collection->updateOne($filter, $update);
            return $result->getModifiedCount();
        } catch (MongoDBException $e){
            return false;
        }
    }
    /**Deleta uma tarefa existente no banco de dados
     * @param string $id O ID da tarefa a ser deletada
     * @return int O numero de documentos deletados.
     */
    public function deletarTarefa($id): int
    {
        try{
            $filter = ['_id' => new ObjectId($id)];
            $result = $this->collection->deleteOne($filter);
            return $result->getDeletedCount();
        } catch (MongoDBException $e){
            return false;
        }
    }
}