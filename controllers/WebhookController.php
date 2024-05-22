<?php

class Webhook
{
    private string $api = 'https://api.mercadopago.com';
    private string $versao = 'v1';
    private ?string $dados;
    private ?string $loc_log = __DIR__;

    public function __construct(private string $chave_privada, private $entrada, private mixed $cn)
    {
    }

    public function executar(): ?object
    {
        $dados = json_decode($this->entrada);

        return match ($dados->type) {
            'payment' => $this->pagamento($dados->data->id),
            default => function () {
                $this->log('Tipo de notificação não reconhecido');
                return null;
            }
        };
    }

    public function salvar(): void
    {
        $this->log('Salvando dados');
        //Coloque aqui sua lógica de salvar os dados do pagamento
        $dados = json_decode($this->dados, 1);

        $ultimos_digitos = '';
        if (!empty($dados['card']['last_four_digits'])) {
            $ultimos_digitos = $dados['card']['last_four_digits'];
        } else {
            $ultimos_digitos = 'null';
        }

        $identificacao = '';
        if (!empty($dados['card']['cardholder']['identification']['number'])) {
            $identificacao = $dados['card']['cardholder']['identification']['number'];
        } else {
            $identificacao = $dados['payer']['identification']['number'];
        }


        $detalhesPagamento = array(
            'status' => $dados['status'],
            'status_detalhado' => $dados['status_detail'],
            'valor_pedido' => $dados['transaction_amount'],
            'moeda' => $dados['currency_id'],
            'tipo_de_pagamento' => $dados['payment_method']['type'],
            'ultimos_digitos_cartao' => $ultimos_digitos,
            'parcelas' => $dados['installments'],
            'bandeira_cartao' => $dados['payment_method_id'],
            'cpf_cliente' => $identificacao,
            'data_pagamento' => $dados['date_created'],
            'ticket_pedido' => $dados['id'],
            'id_cliente' => $dados['external_reference'],
            'data_aprovacao' => $dados['date_approved'],
            'data_vencimento' => $dados['date_of_expiration']
        );

        $id_cliente = (int)$detalhesPagamento['id_cliente'];

        $consulta_dados_cliente = $this->cn->query("SELECT * FROM tbl_usuario WHERE usuario_id = '$id_cliente'");
        $exibe_dados_cliente = $consulta_dados_cliente->fetch(PDO::FETCH_ASSOC);
        $consulta_carrinho_cliente = $this->cn->query("SELECT * FROM tbl_carrinho WHERE usuario_id = '$id_cliente'");
        $exibe_detalhes_pedido = $consulta_carrinho_cliente->fetch(PDO::FETCH_ASSOC);
        $consulta_carrinho_cliente02 = $this->cn->query("SELECT * FROM tbl_carrinho WHERE usuario_id = '$id_cliente'");

        $status = '';
        if ($detalhesPagamento['status'] === 'approved') {
            $status = 'CONCLUIDO';
        } else if ($detalhesPagamento['status'] === 'pending') {
            $status = 'PENDENTE';
        } else if ($detalhesPagamento['status'] === 'rejected') {
            $status = 'CANCELADO';
        }

        $tipo_pagamento = '';
        if ($detalhesPagamento['tipo_de_pagamento'] === 'credit_card') {
            $tipo_pagamento = 'CARTAO';
        } else if ($detalhesPagamento['tipo_de_pagamento'] === 'bank_transfer') {
            $tipo_pagamento = 'TRANSFERENCIA';
        } else if ($detalhesPagamento['tipo_de_pagamento'] === 'ticket') {
            $tipo_pagamento = 'BOLETO';
        }

        $ticket = $detalhesPagamento['ticket_pedido'];
        $logradouro = $exibe_dados_cliente['nome_rua'];
        $numeroCasa = $exibe_dados_cliente['num_casa'];
        $nomeBairro = $exibe_dados_cliente['nome_bairro'];
        $numeroCep = $exibe_dados_cliente['cep'];
        $cidade = $exibe_dados_cliente['cidade'];
        $estado = $exibe_dados_cliente['estado'];
        $pais = $exibe_dados_cliente['pais'];
        $tipoEndereco = 'Residencial';
        $valorTotal = $detalhesPagamento['valor_pedido'];
        $formaDepagamento = $tipo_pagamento;
        $statusPagamento = $status;
        $codigoRastreio = $detalhesPagamento['ticket_pedido'];
        $statusPedido = 'PENDENTE';

        $inserir_pedido = $this->cn->query("INSERT INTO tbl_pedido (ticket_pedido, usuario_id, logradouro, num_casa, nome_bairro, num_cep, cidade, estado, pais, tipo_endereco, valor_total, forma_pagamento, status_pagamento, codigo_rastreio, status_pedido)
         VALUES ('$ticket','$id_cliente','$logradouro','$numeroCasa','$nomeBairro','$numeroCep','$cidade','$estado','$pais','$tipoEndereco','$valorTotal','$formaDepagamento','$statusPagamento','$codigoRastreio','$statusPedido')");

        while ($exibe_resultados_carrinho = $consulta_carrinho_cliente02->fetch(PDO::FETCH_ASSOC)) {
            $codigoProduto = $exibe_resultados_carrinho['produto_id'];

            $consult_preco_produto = $this->cn->query("SELECT nome, custo, preco_promocional, unidade FROM tbl_produto WHERE produto_id = '$codigoProduto'");
            $exibe_detalhes_produto = $consult_preco_produto->fetch(PDO::FETCH_ASSOC);
            $exibeticket = (int)$detalhesPagamento['ticket_pedido'];
            $nome_produto = $exibe_detalhes_produto['nome'];
            $unidade_produto = $exibe_detalhes_produto['unidade'];
            $custo_produto = $exibe_detalhes_produto['custo'];
            $preco_produto = $exibe_detalhes_produto['preco_promocional'];
            $quantidadeProduto = (int)$exibe_resultados_carrinho['quantidade'];

            $inserirProdutoPedido = $this->cn->query("INSERT INTO tbl_pedido_item (ticket_pedido, produto_id, nome_produto, unidade, quantidade, preco_unitario, custo_produto) 
                VALUES ('$exibeticket','$codigoProduto','$nome_produto','$unidade_produto','$quantidadeProduto','$preco_produto', '$custo_produto')");

            $atualizar_estoque_produto = $this->cn->prepare("UPDATE tbl_produto SET quantidade = quantidade - :quantidade WHERE produto_id = :produto_id");
            $atualizar_estoque_produto->bindValue(':quantidade', $quantidadeProduto);
            $atualizar_estoque_produto->bindValue(':produto_id', $codigoProduto);
            $atualizar_estoque_produto->execute();
        }

        $deletar_do_carrinho = $this->cn->query("DELETE FROM tbl_carrinho WHERE usuario_id = '$id_cliente'");
    }

    private function log(string $log): void
    {
        $arquivo = fopen("{$this->loc_log}/log.txt", 'a');
        fwrite($arquivo, date('Y-m-d H:i:s') . ': ' .  mb_convert_encoding($log, 'ISO-8859-1', 'UTF-8') . "\n");
        fclose($arquivo);
    }

    private function pagamento(string $id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->api}/{$this->versao}/payments/{$id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->chave_privada}"
        ]);

        $this->dados = curl_exec($ch);

        if (curl_getinfo($ch)['http_code'] <= 201) {
            $this->log('Requsição recebida: ' . $this->entrada);
            $this->log('Dados recebidos: ' . $this->dados);
        } else {
            $this->log('Erro ao consultar pagamento');
            return null;
        }

        curl_close($ch);
        return $this;
    }
}


$dadosRecebidos = file_get_contents('php://input');
$chave_privada = "TEST-6819797163859486-042622-0bb4b98962c0524f7c5f20053166a16b-669050670";
$entrada = $dadosRecebidos;


$webhook = new Webhook($chave_privada, $entrada, $cn);
$e = $webhook->executar();

if (!is_null($e)) $e->salvar();