<?php

namespace src\models;

use DateTime;
use MongoDB\BSON\ObjectId;
use src\models\enums\Status;

class Tarefa
{
    private ?string $id;
    private string $titulo;
    private string $descricao;
    private Status $status;
    private string $dataVencimento;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        ?string $id,
        string $titulo,
        string $descricao,
        Status $status,
        string $dataVencimento,
        string $createdAt = '',
        string $updatedAt = ''
    ) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->status = $status;
        $this->dataVencimento = $dataVencimento ?: date("Y-m-d");
        $this->createdAt = $createdAt ?: date("Y-m-d");
        $this->updatedAt = $updatedAt ?: date("Y-m-d");
    }

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['_id']) ? (string) $data['_id'] : null,
            $data['titulo'] ?? '',
            $data['descricao'] ?? '',
            Status::from($data['status'] ?? 'NAOINICIADA'),
            $data['dataVencimento'] ?? '',
            $data['createdAt'] ?? '',
            $data['updatedAt'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            '_id' => $this->id ? new ObjectId($this->id) : null,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'status' => (string) $this->status,
            'dataVencimento' => $this->dataVencimento,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getDataVencimento(): ?string
    {
        return $this->dataVencimento;
    }

    public function setDataVencimento(String $dataVencimento): void
    {
        $this->dataVencimento = $dataVencimento;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
