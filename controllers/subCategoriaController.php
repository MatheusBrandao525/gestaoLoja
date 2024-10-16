<?php
require_once "core/Conexao.php";
require_once 'models/DAO/SubCategoriaDAO.php';
require_once 'utils/Utilidades.php';
class SubCategoriaController
{

    public function exibirSubCategoriasDaCategoriaAtual($categoriaId)
    {
        // Inicialize a conexão
        $conexao = Conexao::getInstance()->getConexao();
        $subCategoriaDAO = new SubCategoriaDAO($conexao);
        $categoriaDAO = new CategoriaDAO($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação do ID da categoria
            $categoriaId = filter_input(INPUT_POST, 'categoria_id', FILTER_SANITIZE_NUMBER_INT);

            if (empty($categoriaId)) {
                return ['error' => 'ID da categoria é necessário.'];
            }

            try {
                // Buscando as subcategorias
                $subcategorias = $subCategoriaDAO->buscarSubCategorias($categoriaId);

                if (empty($subcategorias)) {
                    return ['error' => 'Categoria não encontrada.'];
                } else {
                    return [
                        'subcategorias' => $subcategorias,
                        'categoria' => $categoriaDAO->buscarDadosCategoriaPorId($categoriaId) // Você deve implementar esse método para buscar a categoria
                    ];
                }
            } catch (Exception $e) {
                return ['error' => 'Erro ao buscar subcategorias: ' . $e->getMessage()];
            }
        } else {
            http_response_code(405);
            return ['error' => 'Método não permitido. Apenas POST é permitido.'];
        }
    }

    public function cadastroSubCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $subCategoriaDAO = new SubCategoriaDAO($conexao);
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
            $nomeImagemSubcategoria = null; // Definindo como null inicialmente
            if (isset($_FILES['imagemSubcategoria']) && $_FILES['imagemSubcategoria']['error'] === UPLOAD_ERR_OK) {
                $arquivoTmp = $_FILES['imagemSubcategoria']['tmp_name'];
                $extensao = pathinfo($_FILES['imagemSubcategoria']['name'], PATHINFO_EXTENSION);
                $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                $diretorioDestino = "public/assets/img/subcategorias/";
                $caminhoCompleto = $diretorioDestino . $nomeUnico;

                if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                    $nomeImagemSubcategoria = $nomeUnico; // Atribuindo o nome do arquivo apenas se o upload for bem-sucedido
                } else {
                    echo json_encode(['error' => "Erro ao salvar a imagem no servidor."]);
                    return;
                }
            } // Se não houver imagem, $nomeImagemSubcategoria permanecerá null

            // Chamada ao método do DAO para inserir a subcategoria
            $resultado = $subCategoriaDAO->cadastrarSubcategoria($nomeSubcategoria, $categoriaPai, $nomeImagemSubcategoria);
            echo $resultado; // Retorna a resposta do DAO para o frontend
        } else {
            http_response_code(405);
            echo json_encode(['error' => "Invalid request method. Only POST is allowed."]);
        }
    }
}
