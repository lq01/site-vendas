<?php
require_once '../includes/db.php';
require_once '../model/Produto.php';
//TODO: obter dados especificos dos JSONs retornados.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $nome = strtoupper($_POST['nome']);
        $cod_barras = $_POST['cod_barras'];
        $valor = $_POST['valor'];
        $qt_estoque = $_POST['qt_estoque'];

        $produto = new Produto($conn);
        if ($produto->cadastrar($nome, $cod_barras, $valor, $qt_estoque)) {
            echo "Produto cadastrado com sucesso!";  //return no lugar de echo
        } else {
            echo "Erro ao cadastrar o produto."; //return no lugar de echo
        }
    }
    if ($acao === 'buscar_produto_nome_id'){
        $resultado = null;
        $termo_busca = strtoupper($_POST['nome_id_produto']) ?? "";
        if (empty($termo_busca)) {echo "Nome ou ID não fornecidos, retornando todos os resultados: <br>";}

        if (substr($termo_busca,0,1) == "%") { //Busca por nome usando % antes do termo de pesquisa
            $produto_buscado = new Produto($conn);
            $resultado = $produto_buscado->buscarNome(substr($termo_busca, 1));
        } else if (is_numeric($termo_busca)) { //Busca por nome usando % antes do termo de pesquisa
            $produto_buscado = new Produto($conn);
            $resultado = $produto_buscado->buscarID($termo_busca);
        } 
        if ($resultado == null || $resultado === false) {
            echo "Produto(s) não encontrado(s)."; //return no lugar de echo
            return false;
        }
        echo json_encode($resultado, JSON_PRETTY_PRINT); //return no lugar de echo  
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
        $nome_editar = strtoupper($_POST["nome_produto"]) ?? "";
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

