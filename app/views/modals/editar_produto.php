<div class="header_id">
    <label class="titulo_discreto">ID DO PRODUTO</label>
    <h2 id="editar_produto_lbl_ID_produto" style="margin-bottom: 5px;"></h2>
</div>
<form id="form_editar_produto">
    <input type="hidden" name="acao" value="editar_produto">
    <input type="hidden" id="hiddeninput_editar_produto_id_produto" name="id_produto" value="">
    <div id="area_editar_produto">
        <div id="area_editar_produto_informacoes">
            <div class="input_container">
                <label for="nome_produto" class="titulo_discreto">NOME DO PRODUTO</label>
                <input type="text" class="input_form" id="editar_produto_nome_produto" name="nome_produto">
            </div>
            <div class="input_container">
                <label for="cod_barras" class="titulo_discreto">CÓDIGO DE BARRAS</label>
                <input type="number" class="input_form sem-spinner" id="editar_produto_cod_barras" name="cod_barras">
            </div>
            <div class="input_container">
                <label for="valor_produto" class="titulo_discreto">VALOR UNITÁRIO</label>
                <input type="number" class="input_form sem-spinner" id="editar_produto_valor_produto" name="valor_produto" step="0.01">
            </div>
            <div class="input_container">
                <label for="qt_estoque" class="titulo_discreto">QUANTIDADE EM ESTOQUE</label>
                <input type="number" class="input_form" id="editar_produto_qt_estoque" name="qt_estoque">
            </div>

        </div>
        <div id="area_editar_produto_imagem">
            <img class="modal_img_produto" id="img_editar_produto" src="assets/img/image.png">
            <input type="file" class="input_imagem" id="input_editar_imagem_produto" name="upload_imagem" accept="image/*">
        </div>
    </div>
    <div class="modal_painel_botoes">
        <button type="button" class="modal_botao botao_secundario" id="btn_cancelar_edicao_produto" onclick="fecharModalEditarProduto()">Cancelar</button>
        <button type="submit" class="modal_botao botao_confirmar" id="btn_confirmar_edicao_produto">Salvar</button>
    </div>
</form>

