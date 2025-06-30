<?php
require_once '../includes/db.php';
require_once '../model/Produto.php';
require_once '../helpers/ManagerUI.php';
//TODO: obter dados especificos dos JSONs retornados.
//TODO: corrigir salvamento de valores monetarios no banco estão como float ao invés de decimal
//Por conta do tempo curto, algumas funcionalidades funcionarão de maneira mais "grosseira", consequentemente, ocasionando mais consumo de processamento do servidor.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'cadastrar') {
        $nome = mb_strtoupper($_POST['nome_produto']);
        $cod_barras = $_POST['cod_barras'];
        $valor = $_POST['valor_produto'];
        $qt_estoque = $_POST['qt_estoque'];

        $produto = new Produto($conn);
        if ($produto->cadastrar($nome, $cod_barras, $valor, $qt_estoque)) {
            exit("ok");
        } else {
            exit("erro");
        }
    }
    if ($acao === 'buscar_produto_nome_id_codBarras'){
        $resultado = null;
        $termo_busca = mb_strtoupper($_POST['campo_pesquisa_produto'] ?? '');

        if (substr($termo_busca, 0, 1) === "%" || empty($termo_busca)) {
            $produto_buscado = new Produto($conn);
            if (substr($termo_busca, 1, 1) === "%") {
                $resultado = $produto_buscado->buscarCodBarras(substr($termo_busca, 2));
            } else {
                $resultado = $produto_buscado->buscarNome(substr($termo_busca, 1));
            }
        } else if (is_numeric($termo_busca)) {
            $produto_buscado = new Produto($conn);
            $resultado = $produto_buscado->buscarID($termo_busca);
        }
        if (empty($resultado)) {
            echo "<tr><td colspan='5'>Produto(s) não encontrado(s).</td></tr>";
            return;
        }
        echo renderizarLista("pesquisa_produto", json_encode($resultado));
        return;
    }
    if ($acao === 'lancar_estoque_produto'){
        $id = $_POST['id_produto'] ?? "";
        $qt_lancada = $_POST['qt_lancada'] ?? "";
        if (!empty($id) && $qt_lancada > 0) {
            $produto_modificado = new Produto($conn);
            $resultado = $produto_modificado->lancarEstoque($id, $qt_lancada);
            if ($resultado === null || $resultado === false) {
                exit("erro");
            }
            exit("ok");
        }
    }
    if ($acao === 'editar_produto') {
        $id = $_POST['id_produto'] ?? "";
        $nome_editar = mb_strtoupper($_POST["nome_produto"]) ?? "";
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
            exit("ok");
        } else {
            echo "Erro ao modificar produto: Nenhum ID de produto foi fornecido";
        }
        

    }
    if ($acao === 'obter_informacoes_produto') { //Modificar depois para incluir imagem
        $id = intval($_POST['id_produto'] ?? 0);
        $produto = new Produto($conn);
        $resultado = $produto->buscarID($id);
        echo json_encode($resultado);
        return;
    }
}

