<?php

class Produto {
    private $id;
    private $nome;
    private $codigo;
    private $exibePreco;
    private $precoCusto;
    private $precoUnitario;
    private $modelos;
    private $cor;
    private $destaque;
    private $tamanhos;
    private $descricao;
    private $imagem;
    private $imagem2;
    private $imagem3;
    private $categoriaId;

    public function __construct($nome, $codigo, $exibePreco, $precoCusto, $precoUnitario, $modelos, $cor, $destaque, $tamanhos, $descricao, $imagem, $imagem2, $imagem3, $categoriaId) {
        $this->nome = $nome;
        $this->codigo = $codigo;
        $this->exibePreco = $exibePreco;
        $this->precoCusto = $precoCusto;
        $this->precoUnitario = $precoUnitario;
        $this->modelos = $modelos;
        $this->cor = $cor;
        $this->destaque = $destaque;
        $this->tamanhos = $tamanhos;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
        $this->imagem2 = $imagem2;
        $this->imagem3 = $imagem3;
        $this->categoriaId = $categoriaId;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo($codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of exibePreco
     */
    public function getExibePreco()
    {
        return $this->exibePreco;
    }

    /**
     * Set the value of exibePreco
     */
    public function setExibePreco($exibePreco): self
    {
        $this->exibePreco = $exibePreco;

        return $this;
    }

    /**
     * Get the value of precoCusto
     */
    public function getPrecoCusto()
    {
        return $this->precoCusto;
    }

    /**
     * Set the value of precoCusto
     */
    public function setPrecoCusto($precoCusto): self
    {
        $this->precoCusto = $precoCusto;

        return $this;
    }

    /**
     * Get the value of precoUnitario
     */
    public function getPrecoUnitario()
    {
        return $this->precoUnitario;
    }

    /**
     * Set the value of precoUnitario
     */
    public function setPrecoUnitario($precoUnitario): self
    {
        $this->precoUnitario = $precoUnitario;

        return $this;
    }

    /**
     * Get the value of modelos
     */
    public function getModelos()
    {
        return $this->modelos;
    }

    /**
     * Set the value of modelos
     */
    public function setModelos($modelos): self
    {
        $this->modelos = $modelos;

        return $this;
    }

    /**
     * Get the value of cor
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * Set the value of cor
     */
    public function setCor($cor): self
    {
        $this->cor = $cor;

        return $this;
    }

    /**
     * Get the value of destaque
     */
    public function getDestaque()
    {
        return $this->destaque;
    }

    /**
     * Set the value of destaque
     */
    public function setDestaque($destaque): self
    {
        $this->destaque = $destaque;

        return $this;
    }

    /**
     * Get the value of tamanhos
     */
    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    /**
     * Set the value of tamanhos
     */
    public function setTamanhos($tamanhos): self
    {
        $this->tamanhos = $tamanhos;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of imagem
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     */
    public function setImagem($imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get the value of imagem2
     */
    public function getImagem2()
    {
        return $this->imagem2;
    }

    /**
     * Set the value of imagem2
     */
    public function setImagem2($imagem2): self
    {
        $this->imagem2 = $imagem2;

        return $this;
    }

    /**
     * Get the value of imagem3
     */
    public function getImagem3()
    {
        return $this->imagem3;
    }

    /**
     * Set the value of imagem3
     */
    public function setImagem3($imagem3): self
    {
        $this->imagem3 = $imagem3;

        return $this;
    }

    /**
     * Get the value of categoriaId
     */
    public function getCategoriaId()
    {
        return $this->categoriaId;
    }

    /**
     * Set the value of categoriaId
     */
    public function setCategoriaId($categoriaId): self
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }
}