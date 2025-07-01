document.addEventListener("DOMContentLoaded", function () {
    //DETECTA SE BARRA DE PESQUISA FOI DIGITADA
    //Função pra buscar produtos na tabela na página de produtos
    function buscarProdutos(termo) {
        fetch('controllers/produtoController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'acao=buscar_produto_nome_id_codBarras&campo_pesquisa_produto=' + encodeURIComponent(termo)
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('tabela_produtos').innerHTML = html;
        })
        .catch(err => {
            console.error('Erro ao buscar produtos:', err);
        });
    }
    document.addEventListener('input', function (e) {
        if (e.target && e.target.id === 'campo_pesquisa_produto') {
            const termo = e.target.value;
            buscarProdutos(termo);
        }
    });

    // Exibe a lista de produtos ao carregar a página
    document.addEventListener("paginaProdutosCarregada", function () {
        const idProdutoPesquisado = document.getElementById('campo_pesquisa_produto').value;
        buscarProdutos(idProdutoPesquisado);
    
    });
    
    //Detecta se ocorreu upload de imagem no modal de Cadastro de Produto
    document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'input_cadastrar_imagem_produto') {
                const input = e.target;
                const img = document.getElementById('img_cadastro_produto');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        img.src = ev.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    img.src = 'assets/img/image.png';
                }
            }
        });
    //Detecta se ocorreu upload de imagem em Editar Produto
    document.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'input_editar_imagem_produto') {
            const input = e.target;
            const img = document.getElementById('img_editar_produto');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                    atualizarEstadoBotaoConfirmarEdicao();
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                img.src = 'assets/img/image.png'; 
                atualizarEstadoBotaoConfirmarEdicao();
            }
        }
    });
});