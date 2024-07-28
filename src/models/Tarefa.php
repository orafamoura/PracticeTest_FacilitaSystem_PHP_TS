<?php

namespace src\models;
use src\models\enums\Status;

class Tarefa
{
    private ?string $id;
    private string $titulo;
    private string $descricao;
    private Status $status;
    private $dataVencimento;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        ?string $id,
        string $titulo,
        string $descricao,
        Status $status)
        {
            $this->id = $id;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->status = $status;
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

        public function getDataVencimento()
        {
            return $this->dataVencimento;
        }

        public function setDataVencimento($dataVencimento): void
        {
            $this->dataVencimento = $dataVencimento;
        }

        public function getCreatedAt()
        {
            return $this->createdAt;
        }

        public function setCreatedAt($createdAt): void
        {
            $this->createdAt = $createdAt;
        }

        public function getUpdatedAt()
        {
            return $this->updatedAt;
        }

        public function setUpdatedAt($updatedAt): void
        {
            $this->updatedAt = $updatedAt;
        }
}
