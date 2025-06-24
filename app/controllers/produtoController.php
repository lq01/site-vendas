<?php
require_once '../includes/db.php';
require_once '../model/Produto.php';
//TODO: obter dados especificos dos JSONs retornados.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $nome = $_POST['nome'];
        $cod_barras = $_POST['cod_barras'];
        $valor = $_POST['valor'];
        $qt_estoque = $_POST['qt_estoque'];

        $produto = new Produto($conn);
        if ($produto->cadastrar($nome, $cod_barras, $valor, $qt_estoque)) {
            return "Produto cadastrado com sucesso!";
        } else {
            return "Erro ao cadastrar o produto.";
        }
    }
    if ($acao === 'buscar_produto_ID') {
        $id = $_POST['id_produto'] ?? "";
        if (!empty($id)) {
            $produto_buscado = new Produto($conn);
            $resultado = $produto_buscado->buscarID($id);
            if ($resultado === null) {
                echo "Produto não encontrado.";
                return false;
            }
            return json_encode($resultado, JSON_PRETTY_PRINT);
        } else {
            return "ID não fornecido";
        }
}
    if ($acao === 'buscar_produto_nome'){
        $nome_produto = $_POST['nome_produto'] ?? "";
        if (!empty($nome_produto)) {
            $produto_buscado = new Produto($conn);
            $resultado = $produto_buscado->buscarNome($nome_produto);
            if ($resultado === null || $resultado === false) {
                echo "Produto não encontrado.";
                return false;
            }
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        } else {
            return "Nome não fornecido";
        }
    }
    if ($acao === 'lancar_estoque_produto'){
        $id = $_POST['id_produto'] ?? "";
        $qt_lancada = $_POST['qt_lancada'] ?? "";
        if (!empty($id) || $qt_lancada > 0) {
            $produto_modificado = new Produto($conn);
            $resultado = $produto_modificado->lancarEstoque($id, $qt_lancada);
            if ($resultado === null || $resultado === false) {
                return false;
            }
            echo "ID " . $id . ": foram lançadas ". $qt_lancada . " unidades.";
        }
    }
    if ($acao === 'editar_produto') {
        $id = $_POST['id_produto'] ?? "";
        $nome_editar = $_POST["nome_produto"] ?? "";
        $estoque_editar = $_POST["qt_estoque"] ?? "";
        $cod_barras_editar = $_POST["cod_barras"] ?? "";
        $valor_editar = $_POST["valor_produto"] ?? "";
        $status_editar = $_POST["status_produto"] ?? "";
        if (!empty($id)) {
            $produto_modificado = new Produto($conn);
            $resultado = $produto_modificado->editarProduto($id, $cod_barras_editar, $nome_editar, $estoque_editar, $valor_editar, $status_editar);
            if ($resultado === null || $resultado === false) {
                return false;
            }
            echo "Dados de produto alterados com sucesso.";
        } else {
            echo "Erro ao modificar produto: Nenhum ID de produto foi fornecido";
        }
        

    }
}

?>