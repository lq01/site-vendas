//Funções gerais
//MODALS


document.addEventListener("DOMContentLoaded", function () {
//LISTA DE PRODUTOS
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
        buscarProdutos("");
    
    });
    function obter_informacoes_produto(id_produto) {
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
        obter_informacoes_produto(id);
    }
    });

    //Cadastro de produto
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

});


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

window.onclick = function (event) {
  const modal = document.getElementById("modal_cadastro_produto");
  if (event.target === modal) {
    modal.style.display = "none";
  }
}


//27/06/2025 - 00h48:
//RESOLVIDO: Código funciona ao rodar no console. É carregado na página, mas não é executado.
//RESOLVIDO: Erro na barra de pesquisa ao digitar número que começa com '1'
//RESOLVIDO: Largura das colunas da tabela de produtos não está correta


