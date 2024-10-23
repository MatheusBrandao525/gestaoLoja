<?php

require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Produto.php';
require_once 'models/DAO/ProdutoDao.php';
require_once 'controllers/CategoriaController.php';

class ProdutoController
{

    public function telaImportarJsonProdutos()
    {
        include ROOT_PATH . '/views/importarJsonProdutos.php';
    }

    public function mostrarTelaCadastroProduto()
    {
        include ROOT_PATH . '/views/cadastroProduto.php';
    }

    public function telaTodosOsProdutos()
    {
        include ROOT_PATH . '/views/produtos.php';
    }

    public function telaEditarProduto()
    {
        include ROOT_PATH . '/views/editarProduto.php';
    }

    public function telaProdutosPorCategoria()
    {
        include ROOT_PATH . '/views/produtosPorCategoria.php';
    }

    public function exibirTodosOsProdutos()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtosDAO = new ProdutoDao($conexao);
        return $produtosDAO->buscarTodosOsProdutosDatabase();
    }

    public function cadastrarProduto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
            $exibePreco = filter_input(INPUT_POST, 'exibirPreco', FILTER_SANITIZE_STRING);
            $precoCusto = filter_input(INPUT_POST, 'precoCusto', FILTER_SANITIZE_NUMBER_FLOAT);
            $precoUnitario = filter_input(INPUT_POST, 'precoUnitario', FILTER_SANITIZE_NUMBER_FLOAT);
            $modelos = filter_input(INPUT_POST, 'modelos', FILTER_SANITIZE_STRING);
            $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_STRING);
            $destaque = filter_input(INPUT_POST, 'destaque', FILTER_SANITIZE_STRING);
            $tamanhos = filter_input(INPUT_POST, 'tamanhos', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $categoriaId = filter_input(INPUT_POST, 'categoriaid', FILTER_SANITIZE_STRING);

            $validarSeCamposEstaoVazios = new Utilidades();

            $validarSeCamposEstaoVazios->validarCampoVazio($nome, "Nome");
            $validarSeCamposEstaoVazios->validarCampoVazio($codigo, "Código");
            $validarSeCamposEstaoVazios->validarCampoVazio($exibePreco, "Exibir Preço");
            $validarSeCamposEstaoVazios->validarCampoVazio($precoCusto, "Preço de Custo");
            $validarSeCamposEstaoVazios->validarCampoVazio($precoUnitario, "Preço Unitário");
            $validarSeCamposEstaoVazios->validarCampoVazio($modelos, "Modelos");
            $validarSeCamposEstaoVazios->validarCampoVazio($cor, "Cor");
            $validarSeCamposEstaoVazios->validarCampoVazio($destaque, "Destaque");
            $validarSeCamposEstaoVazios->validarCampoVazio($tamanhos, "Tamanhos");
            $validarSeCamposEstaoVazios->validarCampoVazio($descricao, "Descrição");
            $validarSeCamposEstaoVazios->validarCampoVazio($categoriaId, "Categoria ID");

            $diretorioDestino = "public/assets/img/produtos/";
            $imagensNomes = [null, null, null];
    
            if (isset($_FILES['imagem1']) && $_FILES['imagem1']['error'] === UPLOAD_ERR_OK) {
                $imagensNomes[0] = $this->processarImagem($_FILES['imagem1'], $diretorioDestino);
                $imagensNomes[0] = PAINEL_URL_BASE . '/' . $diretorioDestino . $imagensNomes[0];
            } elseif ($_FILES['imagem1']['error'] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Erro ao carregar a imagem imagem1: " . $_FILES['imagem1']['error']);
            }

            if (isset($_FILES['imagem2']) && $_FILES['imagem2']['error'] === UPLOAD_ERR_OK) {
                $imagensNomes[1] = $this->processarImagem($_FILES['imagem2'], $diretorioDestino);
                $imagensNomes[1] = PAINEL_URL_BASE . '/' . $diretorioDestino . $imagensNomes[1];
            } elseif ($_FILES['imagem2']['error'] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Erro ao carregar a imagem imagem2: " . $_FILES['imagem2']['error']);
            }


            if (isset($_FILES['imagem3']) && $_FILES['imagem3']['error'] === UPLOAD_ERR_OK) {
                $imagensNomes[2] = $this->processarImagem($_FILES['imagem3'], $diretorioDestino);
                $imagensNomes[2] = PAINEL_URL_BASE . '/' . $diretorioDestino . $imagensNomes[2];
            } elseif ($_FILES['imagem3']['error'] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Erro ao carregar a imagem imagem3: " . $_FILES['imagem3']['error']);
            }

            $conexao = Conexao::getInstance()->getConexao();
            $produtoDao = new ProdutoDao($conexao);

            $produto = new Produto(
                $nome,
                $codigo,
                $exibePreco,
                $precoCusto,
                $precoUnitario,
                $modelos,
                $cor,
                $destaque,
                $tamanhos,
                $descricao,
                $imagensNomes[0] ?? null,
                $imagensNomes[1] ?? null,
                $imagensNomes[2] ?? null,
                $categoriaId
            );
            $produtoDao->cadastro($produto);
        } else {
            throw new Exception("Invalid request method.");
        }
    }

    public function mostraDadosProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
            $dadosProduto = $produtoDAO->buscarDadosProdutoPorId($produtoId);
            $categoriaController = new CategoriaController();
            if (!isset($dadosProduto['error'])) {
                $dadosProduto['status_destaque'] = $dadosProduto['destaque'] ? 'Sim' : 'Não';
                $dadosProduto['status_exibe_preco'] = $dadosProduto['exibe_preco'] ? 'Sim' : 'Não';
                $dadosProduto['nome_categoria'] = $categoriaController->mostarNomeCategoria($dadosProduto['categoria_id']);
            }

            return $dadosProduto;
        } else {
            echo json_encode(['success' => false, 'error' => 'Houve um erro ao tentar buscar os dados do produto.']);
        }
    }


    public function excluirProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $produtoId = $data['produtoId'] ?? null;
                $produtoDAO = new ProdutoDAO($conexao);
                if (isset($produtoId)) {
                    $resultado = $produtoDAO->excluirProdutoDatabase($produtoId);
                    echo json_encode($resultado);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
                }
                exit;
            }
        }
    }

    public function alterarDadosProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
                $produtoAtual = $produtoDAO->buscarDadosProdutoPorId($produtoId);

                // Carrega os campos do formulário
                $nome = filter_input(INPUT_POST, 'altera-nome', FILTER_SANITIZE_STRING);
                $codigo = filter_input(INPUT_POST, 'altera-codigo', FILTER_SANITIZE_STRING);
                $exibePreco = filter_input(INPUT_POST, 'altera-exibirPreco', FILTER_SANITIZE_STRING);
                $precoCusto = filter_input(INPUT_POST, 'altera-precoCusto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $precoUnitario = filter_input(INPUT_POST, 'altera-precoUnitario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $modelos = filter_input(INPUT_POST, 'altera-modelos', FILTER_SANITIZE_STRING);
                $cor = filter_input(INPUT_POST, 'altera-cor', FILTER_SANITIZE_STRING);
                $destaque = filter_input(INPUT_POST, 'altera-destaque', FILTER_SANITIZE_STRING);
                $tamanhos = filter_input(INPUT_POST, 'altera-tamanhos', FILTER_SANITIZE_STRING);
                $descricao = filter_input(INPUT_POST, 'altera-descricao', FILTER_SANITIZE_STRING);
                $categoriaId = filter_input(INPUT_POST, 'altera-categoriaid', FILTER_SANITIZE_NUMBER_INT);

                $dadosParaAtualizar = [];
                foreach (['nome', 'codigo', 'exibe_preco', 'preco_custo', 'preco_unitario', 'modelos', 'cor', 'destaque', 'tamanhos', 'descricao', 'categoria_id'] as $campo) {
                    if (isset($$campo) && $$campo != $produtoAtual[$campo]) {
                        $dadosParaAtualizar[$campo] = $$campo;
                    }
                }

                $imagens = ['altera-imagem1', 'altera-imagem2', 'altera-imagem3'];
                foreach ($imagens as $key => $imagem) {
                    if (isset($_FILES[$imagem]) && $_FILES[$imagem]['error'] === UPLOAD_ERR_OK) {
                        $nomeCampoImagem = 'imagem' . ($key + 1);
                        $arquivoAntigo = $produtoAtual[$nomeCampoImagem];
                        if ($arquivoAntigo) {
                            @unlink("public/assets/img/produtos/" . $arquivoAntigo);
                        }
                        $diretorioDestino = "public/assets/img/produtos/";
                        $nomeImagem = $this->processarImagem($_FILES[$imagem], $diretorioDestino);
                        $dadosParaAtualizar[$nomeCampoImagem] = PAINEL_URL_BASE . '/' . $diretorioDestino . $nomeImagem; // Construir URL completa
                    }
                }


                if (!empty($dadosParaAtualizar)) {
                    $produto = new Produto(
                        $dadosParaAtualizar['nome'] ?? $produtoAtual['nome'],
                        $dadosParaAtualizar['codigo'] ?? $produtoAtual['codigo'],
                        $dadosParaAtualizar['exibe_preco'] ?? $produtoAtual['exibe_preco'],
                        $dadosParaAtualizar['preco_custo'] ?? $produtoAtual['preco_custo'],
                        $dadosParaAtualizar['preco_unitario'] ?? $produtoAtual['preco_unitario'],
                        $dadosParaAtualizar['modelos'] ?? $produtoAtual['modelos'],
                        $dadosParaAtualizar['cor'] ?? $produtoAtual['cor'],
                        $dadosParaAtualizar['destaque'] ?? $produtoAtual['destaque'],
                        $dadosParaAtualizar['tamanhos'] ?? $produtoAtual['tamanhos'],
                        $dadosParaAtualizar['descricao'] ?? $produtoAtual['descricao'],
                        $dadosParaAtualizar['imagem1'] ?? $produtoAtual['imagem1'],
                        $dadosParaAtualizar['imagem2'] ?? $produtoAtual['imagem2'],
                        $dadosParaAtualizar['imagem3'] ?? $produtoAtual['imagem3'],
                        $dadosParaAtualizar['categoria_id'] ?? $produtoAtual['categoria_id']
                    );
                    $resposta = $produtoDAO->atualizarProdutoDatabase($produtoId, $produto);
                    if (isset($resposta['success'])) {
                        echo json_encode(['Status' => 'success', 'message' => $resposta['message']]);
                    } elseif (isset($resposta['error'])) {
                        echo json_encode(['error' => $resposta['error']]);
                    } else {
                        echo json_encode(['error' => "Erro desconhecido."]);
                    }
                } else {
                    echo json_encode(['error' => "Nenhuma alteração foi feita."]);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => "Invalid request method."]);
        }
    }


    public function excluirImagemProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
            $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_STRING);

            $conexao = Conexao::getInstance()->getConexao();
            $produtoDAO = new ProdutoDAO($conexao);

            $resultado = $produtoDAO->excluirImagemProdutoDatabase($produtoId, $imagem);

            header('Content-Type: application/json');
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Imagem excluída com sucesso.']);
            } else {
                echo json_encode(['error' => 'Falha ao excluir a imagem.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método de requisição não permitido.']);
        }
    }

    public function buscarProdutosPorCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtos = null; // Inicializar com null
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = filter_input(INPUT_POST, 'categoriaId', FILTER_SANITIZE_NUMBER_INT);
            $produtoDAO = new ProdutoDAO($conexao);
            $produtos = $produtoDAO->buscarProdutosPorCategoriaDatabase($categoriaId);
        } else {
            $produtos = ['error' => 'Método de requisição não permitido.'];
        }
        return $produtos; // Retornar produtos ou erro
    }

    private function processarImagem($file, $diretorioDestino)
    {
        $imagemTemp = $file['tmp_name'];
        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nomeImagem = md5(uniqid(rand(), true)) . '.' . $extensao;
        $caminhoCompleto = $diretorioDestino . $nomeImagem;
        if (move_uploaded_file($imagemTemp, $caminhoCompleto)) {
            return $nomeImagem;
        } else {
            throw new Exception("Falha ao mover a imagem para o diretório de destino.");
        }
    }

    public function importarProdutosJson()
    {
        try {
            $conexao = Conexao::getInstance()->getConexao();
            $utilidades = new Utilidades();
    
            // Verifica se é uma requisição POST e se o arquivo foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileUpload'])) {
                // Verifica se houve erro no upload do arquivo
                if ($_FILES['fileUpload']['error'] != UPLOAD_ERR_OK) {
                    throw new Exception("Erro no upload: " . $_FILES['fileUpload']['error']);
                }
    
                // Lê o conteúdo do arquivo
                $jsonFile = file_get_contents($_FILES['fileUpload']['tmp_name']);
                // Converte o conteúdo para UTF-8
                $jsonFile = mb_convert_encoding($jsonFile, 'UTF-8', 'auto');
                // Decodifica o JSON
                $produtos = json_decode($jsonFile, true);
    
                // Verifica se houve erro na decodificação do JSON
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Erro ao decodificar o JSON: " . json_last_error_msg());
                }
    
                // Verifica se o conteúdo decodificado é um array
                if (!is_array($produtos)) {
                    throw new Exception("Erro ao decodificar o JSON.");
                }
    
                // Obtém o ID da categoria do formulário
                $categoriaId = isset($_POST['grupoProduto']) ? $_POST['grupoProduto'] : null;
                $subcategoriaId = isset($_POST['subgrupoProduto']) ? $_POST['subgrupoProduto'] : null;
    
                // Verifica se o ID da categoria foi enviado
                if (!$categoriaId) {
                    throw new Exception("O ID da categoria não está definido.");
                }
    
                // Verifica se a categoria existe
                $stmtCategoria = $conexao->prepare("SELECT categoria_id FROM categorias WHERE categoria_id = ?");
                $stmtCategoria->execute([$categoriaId]);
                if (!$stmtCategoria->fetch()) {
                    throw new Exception("Categoria com ID $categoriaId não existe.");
                }
    
                // Verifica se a subcategoria existe (opcional, caso subcategoria seja necessária)
                if ($subcategoriaId) {
                    $stmtSubcategoria = $conexao->prepare("SELECT subcategoria_id FROM subcategorias WHERE subcategoria_id = ?");
                    $stmtSubcategoria->execute([$subcategoriaId]);
                    if (!$stmtSubcategoria->fetch()) {
                        throw new Exception("Subcategoria com ID $subcategoriaId não existe.");
                    }
                }
    
                // Itera sobre cada produto no array
                foreach ($produtos as $produto) {
                    // Formata datas de início e fim da promoção para o formato MySQL
                    $inicioPromocao = $utilidades->formatarDataParaMySQL($produto['inicio_promocao']);
                    $fimPromocao = $utilidades->formatarDataParaMySQL($produto['fim_promocao']);
    
                    // Verifica se o produto já existe no banco de dados
                    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE codigo = ?");
                    $stmt->execute([$produto['id']]);
                    $produtoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($produtoExistente) {
                        // Atualiza o produto existente
                        $camposParaAtualizar = [];
                        $valoresParaAtualizar = [];
    
                        foreach ($produto as $campo => $valor) {
                            if ($campo === 'id') continue; // Ignora o campo 'id'
    
                            // Substitui as datas de promoção pelos valores formatados
                            if ($campo === 'inicio_promocao') $valor = $inicioPromocao;
                            if ($campo === 'fim_promocao') $valor = $fimPromocao;
    
                            // Mapeia o campo 'id_grupo' para 'categoria_id'
                            if ($campo === 'id_grupo') $campo = 'categoria_id';
    
                            // Verifica se o valor no banco é diferente do valor atual
                            if ($produtoExistente[$campo] != $valor) {
                                $camposParaAtualizar[] = "$campo = ?";
                                $valoresParaAtualizar[] = $valor;
                            }
                        }
    
                        // Se houver campos a atualizar, executa a query de atualização
                        if (count($camposParaAtualizar) > 0) {
                            $sqlUpdate = "UPDATE produtos SET " . implode(', ', $camposParaAtualizar) . " WHERE codigo = ?";
                            $valoresParaAtualizar[] = $produto['id'];
                            $stmtUpdate = $conexao->prepare($sqlUpdate);
                            $stmtUpdate->execute($valoresParaAtualizar);
                        }
                    } else {
                        // Insere um novo produto no banco de dados
                        $sql = "INSERT INTO produtos (codigo, nome, descricao, unidade, categoria_id, subcategoria_id, preco_venda_1, preco_venda_2, preco_venda_3, preco_venda_4, preco_venda_5, preco_promocao, inicio_promocao, fim_promocao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conexao->prepare($sql);
                        $stmt->execute([
                            $produto['id'],
                            $produto['nome'],
                            $produto['descricao'],
                            $produto['unidade'],
                            $categoriaId, // Usar o ID da categoria enviado pelo formulário
                            $subcategoriaId,
                            $produto['preco_venda_1'],
                            $produto['preco_venda_2'],
                            $produto['preco_venda_3'],
                            $produto['preco_venda_4'],
                            $produto['preco_venda_5'],
                            $produto['preco_promocao'],
                            $inicioPromocao,
                            $fimPromocao
                        ]);
                    }
                }
    
                echo "Produtos importados com sucesso!";
            }
        } catch (Exception $e) {
            // Captura e exibe qualquer exceção durante a execução
            echo "Erro ao importar produtos: " . $e->getMessage();
        }
    }
    

    public function processarImagensImportadas()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imageUpload'])) {
            $fileCount = count($_FILES['imageUpload']['name']);
    
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['imageUpload']['error'][$i] !== UPLOAD_ERR_OK) {
                    echo "Erro no upload do arquivo " . $_FILES['imageUpload']['name'][$i] . ": " . $_FILES['imageUpload']['error'][$i];
                    continue;
                }
    
                $jsonFile = file_get_contents($_FILES['imageUpload']['tmp_name'][$i]);
                $imagensProdutos = json_decode($jsonFile, true);
    
                if (!is_array($imagensProdutos)) {
                    echo "Erro ao decodificar o JSON.";
                    exit();
                }
    
                foreach ($imagensProdutos as $imagemProduto) {
                    $produtoId = $imagemProduto['id_produto'];
                    $extensao = $imagemProduto['extensao'];
                    $imagemBase64 = $imagemProduto['foto'];
    
                    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE codigo = ?");
                    $stmt->execute([$produtoId]);
                    $produtoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($produtoExistente) {
                        $imagemBinaria = base64_decode($imagemBase64);
                        if ($imagemBinaria === false) {
                            echo "Erro ao decodificar imagem em base64 para o produto ID: $produtoId\n";
                            continue;
                        }
    
                        $nomeUnicoImagem = md5($imagemBase64 . microtime()) . $extensao;
    
                        $caminhoSalvar = "public/assets/img/produtos/$nomeUnicoImagem";
    
                        if (!file_put_contents($caminhoSalvar, $imagemBinaria)) {
                            echo "Erro ao salvar a imagem para o produto ID: $produtoId\n";
                            continue;
                        }
    
                        $urlCompletaImagem = PAINEL_URL_BASE . '/' . $caminhoSalvar;
    
                        $sqlConsulta = "SELECT imagem1, imagem2, imagem3 FROM produtos WHERE codigo = ?";
                        $stmtConsulta = $conexao->prepare($sqlConsulta);
                        $stmtConsulta->execute([$produtoId]);
                        $resultado = $stmtConsulta->fetch();
    
                        if ($resultado) {
                            $campoAtualizar = null;
                            if (empty($resultado['imagem1'])) {
                                $campoAtualizar = 'imagem1';
                            } elseif (empty($resultado['imagem2'])) {
                                $campoAtualizar = 'imagem2';
                            } elseif (empty($resultado['imagem3'])) {
                                $campoAtualizar = 'imagem3';
                            }
    
                            if ($campoAtualizar) {
                                $sqlUpdate = "UPDATE produtos SET $campoAtualizar = ? WHERE codigo = ?";
                                $stmtUpdate = $conexao->prepare($sqlUpdate);
                                $stmtUpdate->execute([$urlCompletaImagem, $produtoId]);
                            } else {
                                echo "Todos os campos de imagem para este produto já estão preenchidos.";
                            }
                        } else {
                            echo "Produto não encontrado.";
                        }
                    } else {
                        echo "Produto ID: $produtoId não encontrado.\n";
                    }
                }
            }
        }
    }
    

    public function pesquisaProdutos()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

        $sql = "SELECT * FROM produtos WHERE nome LIKE ? OR codigo LIKE ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["%$pesquisa%", "%$pesquisa%"]);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($produtos as $produto) {
            echo '<div class="produto-item">';
            echo '<div class="produto-imagem">';
            echo '<img src="public/assets/img/produtos/' . $produto['imagem1'] . '" alt="Imagem do produto">';
            echo '</div>';
            echo '<div class="produto-info">';
            echo '<span class="produto-nome">' . htmlspecialchars($produto['nome']) . '</span>';
            echo '<div class="produto-opcoes">';
            echo '<form action="editarProduto" method="post">';
            echo '<input type="hidden" name="produtoId" value="' . $produto['produto_id'] . '">';
            echo '<button type="submit" class="btn-editar-produto" data-produto-id="' . $produto['produto_id'] . '">Editar</button>';
            echo '</form>';
            echo '<button class="btn-excluir-produto" data-produto-id="' . $produto['produto_id'] . '">Excluir</button>';
            echo '</div></div></div>';
        }
    }

    public function exibirUltimosProdutosCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);

        return $ultimosProdutosCadastrados = $produtoDAO->buscarUltimosProdutosCadastrados();
    }

    public function exibirQuantidadeDeProdutosCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);

        return $quantidadeProdutos = $produtoDAO->contarProdutosCadastrados();
    }
}