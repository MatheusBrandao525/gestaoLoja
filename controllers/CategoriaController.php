<?php
require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Categoria.php';
require_once 'models/DAO/CategoriaDAO.php';

class CategoriaController
{
    public function telaCadastrarCategoria()
    {
        include ROOT_PATH . '/views/cadastroCategoria.php';
    }

    public function telaCadastrarSubcategoria()
    {
        include ROOT_PATH . '/views/cadastroSubcategoria.php';
    }

    public function telaEditarCategoria()
    {
        include ROOT_PATH . '/views/editarCategoria.php';
    }

    public function telaCategorias()
    {
        include ROOT_PATH . '/views/categorias.php';
    }

    public function telaImportarCategorias()
    {
        include ROOT_PATH . '/views/importarJsonCategorias.php';
    }

    public function cadastrarCategoria()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_STRING);

            $validarSeCamposEstaoVazios = new utilidades();
            $validarSeCamposEstaoVazios->validarCampoVazio($nomeCategoria, "Nome");


            $nomeImagemCategoria = null;
            if (isset($_FILES['imagemCategoria']) && $_FILES['imagemCategoria']['error'] === UPLOAD_ERR_OK) {
                $arquivoTmp = $_FILES['imagemCategoria']['tmp_name'];
                $extensao = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_EXTENSION);
                $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                $diretorioDestino = "public/assets/img/categorias/";
                $caminhoCompleto = $diretorioDestino . $nomeUnico;
                if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                    $nomeImagemCategoria = $nomeUnico;
                } else {
                    echo json_encode(['error' => "Erro ao salvar a imagem no servidor."]);
                    return;
                }
            } else {
                echo json_encode(['error' => "Erro ao carregar a imagem. Error Code: " . $_FILES['imagemCategoria']['error']]);
                return;
            }

            $conexao = Conexao::getInstance()->getConexao();
            $categoria = new Categoria($nomeCategoria, $nomeImagemCategoria);
            $categoriaDAO = new CategoriaDAO($conexao);
            $cadastrarCategoria = $categoriaDAO->cadastro($categoria);
        } else {
            http_response_code(405);
            echo json_encode(['error' => "Invalid request method. Only POST is allowed."]);
        }
    }


    public function exibirTodasAsCategorias()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        return $categoriaDAO->buscarTodasCategoriasDatabase();
    }

    public function mostraDadosCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_NUMBER_INT);
            $categoriaDAO = new CategoriaDAO($conexao);

            $dadosCategoria = $categoriaDAO->buscarDadosCategoriaPorId($categoriaId);

            return $dadosCategoria;
        } else {
            echo json_encode(['success' => false, 'error' => 'Houve um erro ao tentar buscar os dados da categoria.']);
        }
    }

    public function mostarNomeCategoria($categoriaId)
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        $resultado = $categoriaDAO->buscarNomeCategoriaPorId($categoriaId);
        return $resultado['nome_categoria'] ?? "Categoria não encontrada";
    }

    public function excluirCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $categoriaId = $data['categoriaId'] ?? null;
            $imagemCategoria = $data['imagemCategoria'] ?? null;
            $categoriaDAO = new CategoriaDAO($conexao);
            if ($categoriaId && $imagemCategoria) {
                $resultado = $categoriaDAO->excluirCategoriaDatabase($categoriaId, $imagemCategoria);
                echo json_encode($resultado);
            } else {
                echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
            }
            exit;
        }
    }
    public function excluirSubcategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();

        // Verifica se o método da requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Obtém os dados enviados via POST
            $subcategoriaId = $_POST['subcategoria_id'] ?? null;
            $imagemsubcategoria = $_POST['imagemsubcategoria'] ?? null;

            // Instancia o DAO de Categoria
            $categoriaDAO = new CategoriaDAO($conexao);

            if ($subcategoriaId) {
                // Exclui a subcategoria do banco de dados
                $resultado = $categoriaDAO->excluirSubcategoriaDatabase($subcategoriaId);

                if ($resultado) {
                    // Verifica se há uma imagem associada e tenta excluí-la (se fornecida)
                    if (!empty($imagemsubcategoria)) {
                        $caminhoImagem = "caminho/para/o/diretorio/imagens/" . $imagemsubcategoria;

                        // Verifica se o arquivo de imagem existe no diretório
                        if (file_exists($caminhoImagem)) {
                            // Tenta excluir o arquivo de imagem
                            if (!unlink($caminhoImagem)) {
                                // Caso a exclusão da imagem falhe, retorna um aviso
                                echo json_encode(['success' => true, 'message' => 'Subcategoria excluída, mas a imagem não pôde ser excluída.']);
                                exit;
                            }
                        }
                    }

                    // Caso a subcategoria tenha sido excluída com sucesso (e a imagem, se houver)
                    echo json_encode(['success' => true, 'message' => 'Subcategoria excluída com sucesso.']);
                } else {
                    // Caso ocorra algum erro ao excluir a subcategoria no banco de dados
                    echo json_encode(['success' => false, 'error' => 'Erro ao excluir a subcategoria do banco de dados.']);
                }
            } else {
                // Caso os dados sejam insuficientes, retorna uma mensagem de erro
                echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
            }

            exit;
        }
    }


    public function editarCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $categoriaId = filter_input(INPUT_POST, 'categoriaId', FILTER_SANITIZE_NUMBER_INT);
                $categoriaAtual = $categoriaDAO->buscarDadosCategoriaPorId($categoriaId);

                $nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_STRING);
                $dadosParaAtualizar = [];

                if ($nomeCategoria && $nomeCategoria !== $categoriaAtual['nome_categoria']) {
                    $dadosParaAtualizar['nome_categoria'] = $nomeCategoria;
                }

                if (isset($_FILES['imagemCategoria']) && $_FILES['imagemCategoria']['error'] === UPLOAD_ERR_OK) {
                    $arquivoAntigo = $categoriaAtual['imagem_categoria'] ?? null;
                    if ($arquivoAntigo) {
                        @unlink("public/assets/img/categorias/" . $arquivoAntigo);
                    }
                    $arquivoTmp = $_FILES['imagemCategoria']['tmp_name'];
                    $nomeOriginal = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_FILENAME);
                    $extensao = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_EXTENSION);
                    $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                    $diretorioDestino = "public/assets/img/categorias/";
                    $caminhoCompleto = $diretorioDestino . $nomeUnico;
                    move_uploaded_file($arquivoTmp, $caminhoCompleto);
                    $dadosParaAtualizar['imagem_categoria'] = $nomeUnico;
                }

                if (!empty($dadosParaAtualizar)) {
                    $categoria = new Categoria(
                        $dadosParaAtualizar['nome_categoria'] ?? $categoriaAtual['nome_categoria'],
                        $dadosParaAtualizar['imagem_categoria'] ?? $categoriaAtual['imagem_categoria']
                    );
                    $resposta = $categoriaDAO->atualizarCategoriaDatabase($categoriaId, $categoria);
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

    public function importarCategoriasJson()
    {
        try {
            $conexao = Conexao::getInstance()->getConexao();
            $utilidades = new Utilidades();
    
            // Verifica se é uma requisição POST e se o arquivo foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['categoriasFileUpload'])) {
                // Verifica se houve erro no upload do arquivo
                if ($_FILES['categoriasFileUpload']['error'] != UPLOAD_ERR_OK) {
                    throw new Exception("Erro no upload: " . $_FILES['categoriasFileUpload']['error']);
                }
    
                // Lê o conteúdo do arquivo
                $jsonFile = file_get_contents($_FILES['categoriasFileUpload']['tmp_name']);
                // Converte o conteúdo para UTF-8
                $jsonFile = mb_convert_encoding($jsonFile, 'UTF-8', 'auto');
                // Decodifica o JSON
                $categorias = json_decode($jsonFile, true);
    
                // Verifica se houve erro na decodificação do JSON
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Erro ao decodificar o JSON: " . json_last_error_msg());
                }
    
                // Verifica se o conteúdo decodificado é um array
                if (!is_array($categorias)) {
                    throw new Exception("Erro ao decodificar o JSON.");
                }
    
                // Itera sobre cada categoria no array
                foreach ($categorias as $categoria) {
                    // Verifica se o campo 'id' está definido
                    if (!isset($categoria['id'])) {
                        throw new Exception("O ID da categoria não está definido para a categoria: " . json_encode($categoria));
                    }
    
                    // Verifica se a categoria já existe no banco de dados
                    $stmt = $conexao->prepare("SELECT * FROM categorias WHERE categoria_id = ?");
                    $stmt->execute([$categoria['id']]);
                    $categoriaExistente = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($categoriaExistente) {
                        // Atualiza a categoria existente
                        $camposParaAtualizar = [];
                        $valoresParaAtualizar = [];
    
                        foreach ($categoria as $campo => $valor) {
                            if ($campo === 'id') continue; // Ignora o campo 'id'
    
                            // Se o campo for 'nome', renomeia para 'nome_categoria'
                            if ($campo === 'nome') {
                                $campo = 'nome_categoria';
                            }
    
                            // Verifica se o valor no banco é diferente do valor atual
                            if (isset($categoriaExistente[$campo]) && $categoriaExistente[$campo] != $valor) {
                                $camposParaAtualizar[] = "$campo = ?";
                                $valoresParaAtualizar[] = $valor;
                            }
                        }
    
                        // Se houver campos a atualizar, executa a query de atualização
                        if (count($camposParaAtualizar) > 0) {
                            $sqlUpdate = "UPDATE categorias SET " . implode(', ', $camposParaAtualizar) . " WHERE categoria_id = ?";
                            $valoresParaAtualizar[] = $categoria['id'];
                            $stmtUpdate = $conexao->prepare($sqlUpdate);
                            $stmtUpdate->execute($valoresParaAtualizar);
                        }
                    } else {
                        // Insere uma nova categoria no banco de dados
                        $sql = "INSERT INTO categorias (categoria_id, nome_categoria) VALUES (?, ?)";
                        $stmt = $conexao->prepare($sql);
                        $stmt->execute([
                            $categoria['id'],
                            $categoria['nome']
                        ]);
                    }
                }
    
                echo "Categorias importadas com sucesso!";
            } else {
                throw new Exception("Arquivo não encontrado!");
            }
        } catch (Exception $e) {
            // Captura e exibe qualquer exceção durante a execução
            echo "Erro ao importar categorias: " . $e->getMessage();
        }
    }
    
    public function exibirQuantidadeDeCategoriasCadastradas()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);

        return $quantidadeCategorias = $categoriaDAO->contarQuantidadeCategoriasCadastradas();
    }

    public function CadastroSubCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        header('Content-Type: application/json');


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizando os inputs
            $nomeSubcategoria = filter_input(INPUT_POST, 'nomeSubcategoria', FILTER_SANITIZE_STRING);
            $categoriaPai = filter_input(INPUT_POST, 'categoriaPai', FILTER_SANITIZE_NUMBER_INT);

            // Validando campos vazios
            $utilidades = new utilidades();
            $utilidades->validarCampoVazio($nomeSubcategoria, "Nome da Subcategoria");
            $utilidades->validarCampoVazio($categoriaPai, "Categoria Pai");

            // Processando a imagem
            $nomeImagemSubcategoria = null;
            if (isset($_FILES['imagemSubcategoria']) && $_FILES['imagemSubcategoria']['error'] === UPLOAD_ERR_OK) {
                $arquivoTmp = $_FILES['imagemSubcategoria']['tmp_name'];
                $extensao = pathinfo($_FILES['imagemSubcategoria']['name'], PATHINFO_EXTENSION);
                $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                $diretorioDestino = "public/assets/img/subcategorias/";
                $caminhoCompleto = $diretorioDestino . $nomeUnico;

                if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                    $nomeImagemSubcategoria = $nomeUnico;
                } else {
                    echo json_encode(['error' => "Erro ao salvar a imagem no servidor."]);
                    return;
                }
            }

            // Chamada ao método do DAO para inserir a subcategoria
            $resultado = $categoriaDAO->cadastrarSubcategoria($nomeSubcategoria, $categoriaPai, $nomeImagemSubcategoria);
            echo $resultado; // Retorna a resposta do DAO para o frontend
        } else {
            http_response_code(405);
            echo json_encode(['error' => "Invalid request method. Only POST is allowed."]);
        }
    }

    public function exibirSubCategoriasDaCategoriaAtual()
    {
        // Inicialize a conexão
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação do ID da categoria
            $categoriaId = filter_input(INPUT_POST, 'categoria_id', FILTER_SANITIZE_NUMBER_INT);

            if (empty($categoriaId)) {
                return ['error' => 'ID da categoria é necessário.'];
            }

            try {
                // Buscando os dados da categoria
                $categoria = $categoriaDAO->buscarDadosCategoriaPorId($categoriaId);
                if (!$categoria) {
                    return ['error' => 'Categoria não encontrada.'];
                }

                // Buscando as subcategorias da categoria
                $subcategorias = $categoriaDAO->buscarSubCategorias($categoriaId);

                // Retornando os dados da categoria e subcategorias
                return [
                    'categoria' => $categoria,
                    'subcategorias' => $subcategorias
                ];
            } catch (Exception $e) {
                return ['error' => 'Erro ao buscar dados: ' . $e->getMessage()];
            }
        } else {
            return ['error' => 'Método não permitido. Apenas POST é permitido.'];
        }
    }

    public function exibirSubGruposParaImportacao()
{
    // Inicialize a conexão
    $conexao = Conexao::getInstance()->getConexao();
    $categoriaDAO = new CategoriaDAO($conexao);

    // Defina o cabeçalho como JSON
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validação do ID do grupo
        $grupoId = filter_input(INPUT_POST, 'categoria_id', FILTER_SANITIZE_NUMBER_INT);

        if (empty($grupoId)) {
            echo json_encode(['error' => 'ID do grupo é necessário.']);
            return;
        }

        try {
            // Buscando os subgrupos do grupo
            $subgrupos = $categoriaDAO->buscarSubCategoriasPorGrupoId($grupoId);

            if (empty($subgrupos)) {
                echo json_encode(['subgrupos' => []]); // Retorne um array vazio se não houver subgrupos
                return;
            }

            // Retornando os subgrupos encontrados
            echo json_encode(['subgrupos' => $subgrupos]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao buscar subgrupos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Método não permitido. Apenas POST é permitido.']);
    }
}

}
