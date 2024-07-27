<?php

namespace src\models;
use src\models\enums\Status;

class Tarefa
{
    private ?int $id;
    private string $titulo;
    private string $descricao;
    private Status $status;
    private string $dataVencimento;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        ?int $id,
        string $titulo,
        string $descricao,
        Status $status,
        string $dataVencimento,
        string $createdAt,
        string $updatedAt)
        {
            $this->id = $id;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->status = $status;
            $this->dataVencimento = $dataVencimento;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }

        public function getId(): ?int
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

        public function getDataVencimento(): string
        {
            return $this->dataVencimento;
        }

        public function setDataVencimento(string $dataVencimento): void
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
