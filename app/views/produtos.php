<!--TODO: PREENCHER AS CLASSES DE BOTÕES DEPOIS -->
<link rel="stylesheet" type="text/css" href="assets/produtos.css">
<div id="produtos">
    <div id="produtos_areaListagem">
        <div id="produtos_navbar">
                <div id="produtos_navbar_pesquisa">
                    <form id="produtos_navbar_pesquisa_form" method="POST" action="controllers/produtoController.php">
                        <input class="produtos_navbar_pesquisa_form_item" type="hidden" name="acao" value="buscar_produto_nome_id_codBarras">
                        <input class="produtos_navbar_pesquisa_form_item" type="text" name="nome_id_produto" placeholder="Nome/ID do produto">
                        <button class="produtos_navbar_pesquisa_form_item" type="submit">Ir</button>
                        <img id="info_pesquisa" src="assets/img/info.png" width="25" height="25" title="Digite % para pesquisar por nome. Digite %% para pesquisar por código de barras.">
                    </form>
                            
                </div>
                <div id="produtos_navbar_cadastrarProduto">
                    <button id="btn_cadastrar_produto">Cadastrar Produto</button>
                </div>
        </div>
            <div id="produtos_areaListagem_containerLista">
                <div id="produtos_listaProdutos">
                    <table id="tabela_lista_produtos">
                        <thead id="lista_produtos_header">
                            <!--O cabeçalho deve permanecer fixo, mas a tabela deve ser rolável,
                            configurar isso depois-->
                            <tr>
                                <th>ID</th>
                                <th>Cód. Barras</th>
                                <th>Nome</th>   
                                <th>Estoque</th>
                                <th>Valor</th>
                        </thead>
                        <tbody id="tabela_produtos">
                            <!-- TODO: Os produtos serão inseridos aqui dinamicamente, configurar isso mais tarde 
                            Devo criar uma classe pra gerar diferentes tabelas de produtos para cada view?-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div id="produtos_areaExibicao">
        <div id="produtos_areaExibicao_detalhes">
            <div id="produtos_areaExibicao_detalhes_areaDadosProduto">
                <h4 class="titulo_discreto">PRODUTO</h4>
                <h1 id="lbl_ID_produto">1</h1>
                <h2 class="lbl_info_produto" id="lbl_nome_produto">COCA-COLA ZERO 2L</h2>
                <h4 class="titulo_discreto">CÓDIGO DE BARRAS</h4>
                <h3 class="lbl_info_produto" id="lbl_codigo_barras">7891234567890</h1>
                <h4 class="titulo_discreto">VALOR UNITÁRIO</h4>
                <h3 class="lbl_info_produto" id="lbl_valor_unitario">R$ 12,00</h1>
                <h4 class="titulo_discreto">ESTOQUE ATUAL</h4>
                <h2 class="lbl_info_produto" id="lbl_estoque_atual">100 un</h1>



            </div>
            <div id="produtos_areaExibicao_detalhes_areaImagemProduto">
                <img id="produtos_imagem_produto" src="assets/img/image.png" height="300" width="300">
            </div>
        </div>
        <div id="produtos_areaExibicao_botoes">
            <button id="btn_editar_dados_produto">Editar Dados</button>
            <button id="btn_lancar_estoque_produto">Lançar Estoque</button>
        </div>
    </div>
</div>
