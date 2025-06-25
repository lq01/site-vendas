<?php
require_once '../includes/db.php';
require_once '../model/Venda.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$acao = $_POST['acao'];
    //if ($acao === 'simular_venda'){
        $venda = new Venda($conn);
        $venda->abrirVenda();
        $venda->adicionarProduto(13, 8);
        $venda->adicionarProduto(14, 100);
        $venda->fecharVenda();
        $venda->registrarVenda('dinheiro');

    //}
}
