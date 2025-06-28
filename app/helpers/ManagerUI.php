<?php
require_once '../model/Produto.php';
require_once '../model/Venda.php';
require_once '../model/Usuario.php';

function renderizarLista($tipo_lista, $conteudo){
    $itens = json_decode($conteudo, true);
    $html = "";
    if($itens == null){
        return false;
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
    if($tipo_lista == 'pesquisa_produto'){ 
    // ID, Cód. Barras, Nome, Estoque, Valor
        foreach ($itens as $item) {
            $html .= "<tr class='linha_resultado' data-id='{$item['id_produto']}'>";
            $html .= "<td class='tabela_colunaID'>" . htmlspecialchars($item['id_produto']) . "</td>";
            $html .= "<td class='tabela_colunaCodBarras'>" . htmlspecialchars($item['codigo_barras']) . "</td>";
            $html .= "<td class='tabela_colunaNome'>" . htmlspecialchars($item['nome']) . "</td>";
            $html .= "<td class='tabela_colunaEstoque'>" . htmlspecialchars($item['qt_estoque']) . "</td>";
            $html .= "<td class='tabela_colunaValor'>" . htmlspecialchars($item['valor']) . "</td>";
            $html .= "</tr>";
        }
        return $html;
}
    if($tipo_lista == 'pesquisa_produto_venda'){
    // ID, Cód. Barras, Nome, Valor

}
return false;
}
