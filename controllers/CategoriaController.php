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

    public function telaCategorias()
    {
        include ROOT_PATH . '/views/categorias.php';
    }

    public function cadastrarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_STRING);
        }

        if (isset($_FILES['imagemCategoria']) && !empty($_FILES['imagemCategoria'])) {
            $imagemCategoria = $_FILES['imagemCategoria']['tmp_name'];
            $nomeImagemCategoria = $_FILES['imagemCategoria']['name'];
            $diretorioDestino = "public/assets/img/categorias/";
            $caminhoCompleto = $diretorioDestino . $nomeImagemCategoria;
            move_uploaded_file($imagemCategoria, $caminhoCompleto);
        } else {
            echo json_encode(['message' => "Erro ao carregar a imagem. Error Code:"]);
        }


        $validarSeCamposEstaoVazios = new utilidades();
        $validarSeCamposEstaoVazios->validarCampoVazio($nomeCategoria, "Nome");

        $conexao = Conexao::getInstance()->getConexao();

        $categoria = new Categoria($nomeCategoria, $nomeImagemCategoria);
        $categoriaDAO = new CategoriaDAO($conexao);
        $categoriaDAO->cadastro($categoria);
    }

    public function exibirTodasAsCategorias()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        return $categoriaDAO->buscarTodasCategoriasDatabase();
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
}
