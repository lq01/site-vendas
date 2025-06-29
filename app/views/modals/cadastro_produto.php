<form id="form_cadastro_produto">
    <input type="hidden" name="acao" value="cadastrar">
    <div id="area_cadastrar">
        <div id="area_cadastrar_informacoes">
            <div class="input_container">
            <label for="nome_produto" class="titulo_discreto">NOME DO PRODUTO</label>
            <input type="text" class="input_form" id="nome_produto" name="nome_produto" required>
            </div>
            <div class="input_container">
            <label for="cod_barras" class="titulo_discreto">CÓDIGO DE BARRAS</label>
            <input type="number" class="input_form sem-spinner" id="cod_barras" name="cod_barras">
            </div>
            <div class="input_container">
            <label for="valor_produto" class="titulo_discreto">VALOR UNITÁRIO</label>
            <input type="number" class="input_form sem-spinner" id="valor_produto" name="valor_produto" step="0.01" required>
            </div>
            <div class="input_container">
            <label for="qt_estoque" class="titulo_discreto">QUANTIDADE EM ESTOQUE</label>
            <input type="number" class="input_form" id="qt_estoque" name="qt_estoque" required>
            </div>
        </div>
        <div id="area_cadastrar_imagem">
            <img class="modal_img_produto" id="img_cadastro_produto" src="assets/img/image.png">
        </div>
    </div>
    <div class="modal_painel_botoes">
        <button type="button" class="modal_botao botao_secundario" id="btn_cancelar_cadastro_produto" onclick="fecharModalCadastro()">Cancelar</button>
        <button type="submit" class="modal_botao botao_confirmar" id="btn_confirmar_cadastro_produto">Cadastrar</button>
    </div>
    
</form>

