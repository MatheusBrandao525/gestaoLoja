<?php

class Subcategoria
{
    private $id;
    private $idCategoriaPai;
    private $nome;
    private $imagem;

    public function __construct($id, $idCategoriaPai, $nome, $imagem)
    {
        $this->id;
        $this->idCategoriaPai;
        $this->nome = $nome;
        $this->imagem = $imagem;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIdCategoriaPai()
    {
        return $this->idCategoriaPai;
    }

    public function setIdCategoriaPai($idCategoriaPai): self
    {
        $this->idCategoriaPai = $idCategoriaPai;

        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }
}
