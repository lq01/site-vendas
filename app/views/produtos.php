<!--TODO: PREENCHER AS CLASSES DE BOTÕES DEPOIS -->
<link rel="stylesheet" type="text/css" href="assets/produtos.css">
<div id="produtos">
    <div id="produtos_areaListagem">
        <div id="produtos_navbar">
                <div id="produtos_navbar_pesquisa">
                    <input type="text" id="campo_pesquisa_produto" name="campo_pesquisa_produto" placeholder="Buscar produto...">
                    <img id="info_pesquisa" src="assets/img/info.png" width="25" height="25" style="border-style: none" title="Digite % para pesquisar por nome. Digite %% para pesquisar por código de barras.">
                    </form>
                            
                </div>
                <div id="produtos_navbar_cadastrarProduto">
                    <button id="btn_cadastrar_produto" onclick="abrirModalCadastro()">Cadastrar Produto</button>
                </div>
        </div>
            <div id="produtos_areaListagem_containerLista">
                <div id="produtos_listaProdutos">
                    <table id="tabela_lista_produtos">
                        <thead id="lista_produtos_header">
                            <tr>
                                <th class="tabela_colunaID">ID</th>
                                <th class="tabela_colunaCodBarras">Cód. Barras</th>
                                <th class="tabela_colunaNome">Nome</th>   
                                <th class="tabela_colunaValor">Valor</th>
                                <th class="tabela_colunaEstoque">Estoque</th>
                        </thead>
                        <tbody id="tabela_produtos">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div id="produtos_areaExibicao" style="display: none">
        <div id="produtos_areaExibicao_detalhes">
            <div id="produtos_areaExibicao_detalhes_areaDadosProduto">
                <h4 class="titulo_discreto">PRODUTO</h4>
                <h1 id="lbl_ID_produto"></h1>
                <h2 class="lbl_info_produto" id="lbl_nome_produto"></h2>
                <h4 class="titulo_discreto">CÓDIGO DE BARRAS</h4>
                <h3 class="lbl_info_produto" id="lbl_codigo_barras"></h1>
                <h4 class="titulo_discreto">VALOR UNITÁRIO</h4>
                <h3 class="lbl_info_produto" id="lbl_valor_unitario"></h1>
                <h4 class="titulo_discreto">ESTOQUE ATUAL</h4>
                <h2 class="lbl_info_produto" id="lbl_estoque_atual"></h1>
            </div>
            <div id="produtos_areaExibicao_detalhes_areaImagemProduto">
                <img id="produtos_imagem_produto" src="assets/img/image.png" height="300" width="300">
            </div>
        </div>
        <div class="painel_botoes" id="produtos_areaExibicao_botoes">
            <button id="btn_editar_dados_produto" class="botao_pagina_secundario" onclick="abrirModalEditarProduto(document.getElementById('lbl_ID_produto').textContent)">Editar Dados</button>
            <button id="btn_lancar_estoque_produto" class="botao_pagina_secundario" onclick="abrirModalLancarEstoque(document.getElementById('lbl_ID_produto').textContent)">Lançar Estoque</button>
        </div>

    </div>
</div>
<div id="modal_cadastro_produto" class="modal" style="display: none;">
  <div class="modal_container" id="modal_cadastro_produto_container">
    <div class="modal_header">
        <h2>Cadastrar Produto</h2>
    </div>
    <div class="modal_conteudo" id="modal_cadastro_produto_conteudo"></div> 
  </div>
</div>
<div id="modal_lancar_estoque" class="modal" style="display: none;">
    <div class="modal_container" id="modal_lancar_estoque_container">
        <div class="modal_header">
            <h2>Lançar Estoque</h2>
        </div>
        <div class="modal_conteudo" id="modal_lancar_estoque_conteudo"></div>
    </div>
</div>
<div id="modal_editar_produto" class="modal" style="display: none;">
    <div class="modal_container" id="modal_editar_produto_container">
        <div class="modal_header">
            <h2>Editar dados do produto</h2>
        </div>
        <div class="modal_conteudo" id="modal_editar_produto_conteudo"></div>
    </div>
</div>



