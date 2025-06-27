<?php
require_once '../model/Produto.php';
require_once '../model/Venda.php';
require_once '../model/Usuario.php';

function renderizarLista($tipo_lista){
    if($tipo_lista == 'pag_produtos_pesquisa'){ 
    // ID, Cód. Barras, Nome, Estoque, Valor
}
    if($tipo_lista == 'adicionar_produto_venda'){
    // ID, Cód. Barras, Nome, Valor
}
    if($tipo_lista == 'produtos_venda'){
    // ID, Cód. Barras, Nome, Qt., V. Unitário, Total
}
    if($tipo_lista == 'registro_vendas'){
    // ID Venda, Data, Valor, Método Pagamento, Produtos
}
    if($tipo_lista == 'registro_venda_produtos_vendidos'){ //Avaliar se isso aqui realmente é necessário
    // ID, Cód. Barras, Nome, Qt., V. Unitário, Total
    }