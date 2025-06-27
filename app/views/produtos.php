<!--TODO: PREENCHER AS CLASSES DE BOTÕES DEPOIS -->
<link rel="stylesheet" type="text/css" href="assets/produtos.css">
<div id="produtos">
    <div id="produtos_area_listagem">
        <div id="produtos_navbar">
            <div id="produtos_navbar_pesquisa"></div>
            <div id="produtos_navbar_cadastrar_produto">
        </div>
        <div id="produtos_lista_produtos">
            <table>
                <thead>
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
    <div id="produtos_area_exibicao">
        <div id="produtos_area_exibicao_detalhes">
            <div id="produtos_area_exibicao_area_dados_produto"></div>
            <div id="produtos_area_exibicao_area_imagem_produto">
                <img id="produtos_imagem_produto" src="assets/img/image.png" height="300" width="300">
            </div>
        </div>
        <div id="produtos_area_exibicao_botoes">
            <button id="editar_dados_produto">Editar Dados</button>
            <button id="lancar_estoque_produto">Lançar Estoque</button>
        </div>
    </div>
</div>