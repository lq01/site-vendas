//Funções gerais
///Eu tenho que organizar melhor esse script depois.
document.addEventListener("DOMContentLoaded", function () {
    //Envia cadastro de produto
    document.addEventListener('submit', function (e) {
        if (e.target && e.target.id === 'form_cadastro_produto') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            fetch('controllers/produtoController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(resposta => {
                if (resposta.trim() === "ok") {
                    fecharModalCadastro();
                    document.dispatchEvent(new Event("paginaProdutosCarregada"));
                } else {
                    alert("Erro ao cadastrar produto: " + resposta);
                }
            })
            .catch(err => {
                alert("Erro ao cadastrar produto.");
                console.error(err);
            });
        }
    });

    //Envia lançamento de unidade no estoque
    document.addEventListener('submit', function(e){
        if (e.target && e.target.id === 'form_lancar_estoque') {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('controllers/produtoController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(resposta => {
                if (resposta.trim() === "ok") {
                    const id_produto = form.querySelector('[name="id_produto"]').value;
                    fecharModalLancarEstoque();
                    obterInformacoesProduto(id_produto);
                    document.dispatchEvent(new Event("paginaProdutosCarregada"));
                } else {
                    alert("Erro ao adicionar estoque de produto: " + resposta);
                }
            })
            .catch(err => {
                alert("Erro ao adicionar estoque de produto.");
                console.error(err);
            });
        }
    })

    // Envia edição de produto
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'form_editar_produto') {
            e.preventDefault();
            const form = e.target;

            const codBarrasInput = document.getElementById('editar_produto_cod_barras');
            let codBarrasValido = false;
            if (codBarrasInput) {
                const val = codBarrasInput.value.trim();
                codBarrasValido = (val === "" || val.length === 13);
            }

            if (!codBarrasValido) {
                alert("O campo Código de Barras deve estar vazio ou conter exatamente 13 caracteres.");
                return;
            }
            
            const formData = new FormData(form);

            fetch('controllers/produtoController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(resposta => {
                if (resposta.trim() === "ok") {
                    const id_produto = form.querySelector('[name="id_produto"]').value;
                    fecharModalEditarProduto();
                    obterInformacoesProduto(id_produto);
                    document.dispatchEvent(new Event("paginaProdutosCarregada"));
                } else {
                    alert("Erro ao editar produto: "+ resposta)
                }
            })
            .catch(err => {
                alert("Ocorreu um erro ao editar produto.");
                console.error(err);
            })
        }
    });
    
});
//MODALS
///1. LANÇAR ESTOQUE
function abrirModalLancarEstoque(id_produto) {
    fetch("views/modals/lancar_estoque.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("modal_lancar_estoque_conteudo").innerHTML = html;
            document.getElementById("modal_lancar_estoque").style.display = "block";
            modalLancarEstoque_obterInformacoesProduto(id_produto);
        })
        .catch(err => console.error("Erro ao carregar modal:", err));
}
function fecharModalLancarEstoque() {
    document.getElementById("modal_lancar_estoque").style.display = "none";
}
////Exibir informações do produto no modal 'Lançar Estoque'
function modalLancarEstoque_obterInformacoesProduto(id_produto) {
    fetch('controllers/produtoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'acao=obter_informacoes_produto&id_produto=' + encodeURIComponent(id_produto)
    })
    .then(res => res.json())
    .then(data => {
        data = data[0];
        if (data && data.id_produto) {
            document.getElementById('hiddeninput_lancar_estoque_id_produto').value = data.id_produto;
            document.getElementById('lancar_estoque_lbl_ID_produto').textContent  = data.id_produto;
            document.getElementById('lancar_estoque_lbl_nome_produto').textContent  = data.nome;
            document.getElementById('lancar_estoque_lbl_estoque_atual').textContent  = data.qt_estoque;
            if (data.imagem) {
                    document.getElementById('img_lancar_estoque_produto').src = 'data:image/png;base64,' + data.imagem;
                } else {
                    document.getElementById('img_lancar_estoque_produto').src = 'assets/img/image.png';
                }
        } else {
            console.error('Produto não encontrado ou dados inválidos:', data);
        }
    })
    .catch(err => {
        console.error('Erro ao obter informações do produto:', err);
    });
}


   
///2. CADASTRO DE PRODUTO
function abrirModalCadastro() {
    fetch("views/modals/cadastro_produto.php")
        .then(res => res.text())
        .then(html => {
        document.getElementById("modal_cadastro_produto_conteudo").innerHTML = html;
        document.getElementById("modal_cadastro_produto").style.display = "block";
        })
        .catch(err => console.error("Erro ao carregar modal:", err));
    }
function fecharModalCadastro() {
document.getElementById("modal_cadastro_produto").style.display = "none";
}
//Fecha o modal ao clicar fora.
window.onclick = function (event) {
    const modalCadastro = document.getElementById("modal_cadastro_produto");
    const modalLancarEstoque = document.getElementById("modal_lancar_estoque");

    if (modalCadastro && event.target === modalCadastro) {
        modalCadastro.style.display = "none";
    }
    if (modalLancarEstoque && event.target === modalLancarEstoque) {
        modalLancarEstoque.style.display = "none";
    }
}

///3. EDITAR DADOS DE PRODUTO
function modalEditarProduto_obterInformacoesProduto(id_produto) {
    fetch('controllers/produtoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'acao=obter_informacoes_produto&id_produto=' + encodeURIComponent(id_produto)
    })
    .then(res => res.json())
    .then(data => {
        data = data[0];
        if (data && data.id_produto) {
            document.getElementById('hiddeninput_editar_produto_id_produto').value = data.id_produto;
            document.getElementById('editar_produto_lbl_ID_produto').textContent = data.id_produto;
            document.getElementById('editar_produto_nome_produto').value  = data.nome;
            document.getElementById('editar_produto_cod_barras').value  = data.codigo_barras;
            document.getElementById('editar_produto_valor_produto').value  = data.valor;
            document.getElementById('editar_produto_qt_estoque').value  = data.qt_estoque;
            if (data.imagem) {
                    document.getElementById('img_editar_produto').src = 'data:image/png;base64,' + data.imagem;
                    document.getElementById('img_editar_produto').dataset.valorOriginal = 'data:image/png;base64,' + data.imagem;
                } else {
                    document.getElementById('img_editar_produto').dataset.valorOriginal = 'assets/img/image.png';
                    document.getElementById('img_editar_produto').src = 'assets/img/image.png';
                }
 
            document.getElementById('editar_produto_nome_produto').dataset.valorOriginal = data.nome;
            document.getElementById('editar_produto_cod_barras').dataset.valorOriginal = data.codigo_barras;
            document.getElementById('editar_produto_valor_produto').dataset.valorOriginal = data.valor;
            document.getElementById('editar_produto_qt_estoque').dataset.valorOriginal = data.qt_estoque;
            
            atualizarEstadoBotaoConfirmarEdicao();
        } else {
            console.error('Produto não encontrado ou dados inválidos:', data);
        }
    })
    .catch(err => {
        console.error('Erro ao obter informações do produto:', err);
    });
}
function abrirModalEditarProduto(id_produto) {
    fetch("views/modals/editar_produto.php")
    .then(res => res.text())
    .then(html => {
        document.getElementById("modal_editar_produto_conteudo").innerHTML = html;
        document.getElementById("modal_editar_produto").style.display = "block";
        modalEditarProduto_obterInformacoesProduto(id_produto);
        setTimeout(() => {
            const campos = [
                'editar_produto_nome_produto',
                'editar_produto_cod_barras',
                'editar_produto_valor_produto',
                'editar_produto_qt_estoque'
            ];
            campos.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', atualizarEstadoBotaoConfirmarEdicao);
                }
            });
        }, 100);
    })
    .catch(err => console.error("Erro ao carregar modal:", err));
}

function fecharModalEditarProduto() {
    document.getElementById("modal_editar_produto").style.display = "none";
}

// Função para atualizar o estado do botão de confirmação
function atualizarEstadoBotaoConfirmarEdicao() {
    const campos = [
        'editar_produto_nome_produto',
        'editar_produto_cod_barras',
        'editar_produto_valor_produto',
        'editar_produto_qt_estoque',
    ];
    const imagemAntiga = document.getElementById('img_editar_produto').dataset.valorOriginal
    const imagemNovaCompleta = document.getElementById('img_editar_produto').src;
    const imagemNova = imagemNovaCompleta.split('/assets/')[1] 
    ? 'assets/' + imagemNovaCompleta.split('/assets/')[1]
    : imagemNovaCompleta;
    let houveMudanca = (
        imagemAntiga !== imagemNova 
        || campos.some(id => {
        const input = document.getElementById(id);
        return input && input.value.trim() !== input.dataset.valorOriginal;  
    })); 

    const codBarrasInput = document.getElementById('editar_produto_cod_barras');
    const nomeInput = document.getElementById('editar_produto_nome_produto');
    let codBarrasValido = false;
    let nomeValido = false;
    if (codBarrasInput) {
        const val = codBarrasInput.value.trim();
        codBarrasValido = (val === "" || val.length === 13);
    }
     if (nomeInput) {
        const val = nomeInput.value.trim();
        nomeValido = !(val === "");
    }

    const btn = document.getElementById('btn_confirmar_edicao_produto');
    if (btn) {
        btn.disabled = !(houveMudanca && codBarrasValido && nomeValido);
    }
}

    //DETECTA SE UM ITEM DA LISTA FOI CLICADO PARA EXIBIR DADOS NO PAINEL LATERAL
    function obterInformacoesProduto(id_produto) {
        fetch('controllers/produtoController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'acao=obter_informacoes_produto&id_produto=' + encodeURIComponent(id_produto)
        })
        .then(res => res.json())
        .then(data => {
            data = data[0];
            if (data && data.id_produto) {
                document.getElementById('lbl_ID_produto').textContent  = data.id_produto;
                document.getElementById('lbl_nome_produto').textContent  = data.nome;
                document.getElementById('lbl_codigo_barras').textContent  = data.codigo_barras;
                document.getElementById('lbl_valor_unitario').textContent  = data.valor;
                document.getElementById('lbl_estoque_atual').textContent  = data.qt_estoque;
                if (data.imagem) {
                    document.getElementById('produtos_imagem_produto').src = 'data:image/png;base64,' + data.imagem;
                } else {
                    document.getElementById('produtos_imagem_produto').src = 'assets/img/image.png';
                }
                document.getElementById('produtos_areaExibicao').style.display = "flex";
                
            } else {
                console.error('Produto não encontrado ou dados inválidos:', data);
            }
        })
        .catch(err => {
            console.error('Erro ao obter informações do produto:', err);
        });
    }
    document.addEventListener("click", function (e) {
        const linha = e.target.closest(".linha_resultado");
        if (linha) {
            const id = linha.getAttribute("data-id");
            obterInformacoesProduto(id);
        }
    });


//POSTERIORMENTE, TRANSFERIR EVENTOS PARA eventos.js

