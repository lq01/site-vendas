<form id="form_lancar_estoque">
    <input type="hidden" name="acao" value="lancar_estoque_produto">
    <input type="hidden" id="hiddeninput_lancar_estoque_id_produto" name="id_produto" value="">
    <div id="area_lancar_estoque">
        <div id="area_lancar_estoque_informacoes"> <!--Modificar esse script -->
                <h5 class="titulo_discreto">PRODUTO</h5>
                <h2 id="lancar_estoque_lbl_ID_produto" style="margin-bottom: 10px;"></h2>
                <h4 class="modal_lbl_info_produto" id="lancar_estoque_lbl_nome_produto"></h4>
                <h5 class="titulo_discreto">ESTOQUE ATUAL</h5>
                <h3 class="modal_lbl_info_produto" id="lancar_estoque_lbl_estoque_atual"></h3>
        </div>
        <div id="area_lancar_estoque_imagem">  
            <img class="modal_img_produto" id="img_lancar_estoque_produto" src="assets/img/image.png">
            <div id="area_lancar_qt_unidades" class="input_container">
                <label class="titulo_discreto" for="qt_lancada" style="margin-bottom: 5px;">LANÇAR UNIDADES</label>
                <input type="number" class="input_form sem-spinner" id="input_lancar_qt_unidades" name="qt_lancada" step="0.01" required>
            </div>
        </div>
    </div>
    <div class="modal_painel_botoes">
        <button type="button" class="modal_botao botao_secundario" id="btn_cancelar_lancar_estoque" onclick="fecharModalLancarEstoque()">Cancelar</button>
        <button type="submit" class="modal_botao botao_confirmar" id="btn_confirmar_lancar_estoque">Adicionar</button>
    </div>
    
</form>


