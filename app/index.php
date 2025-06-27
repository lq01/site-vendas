<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App de Vendas</title>
        <link rel="stylesheet" type="text/css" href="assets/includes.css">
        <script src="assets/index.js" defer></script>

    </head>

    <body>
        <?php include 'includes/header.php'; ?>
        <div id="conteudo">
            <?php 
            $pagina = $_GET['pagina'] ?? 'produtos';
            switch ($pagina) {
                case 'produtos':
                    include 'views/produtos.php';
                    break;
                case 'venda':
                    include 'views/venda.php';
                    break;
                case 'registro_vendas':
                    include 'views/registro_vendas.php';
                    break;
                default:
                    include 'views/produtos.php';
            }
        ?>
        </div>
    </body>
</html>
<!--

<h1>Produtos</h1>
<h2>Cadastrar um produto</h2>
<form method="POST" action="controllers/produtoController.php">
    <input type="hidden" name="acao" value="cadastrar">
    <input type="text" name="nome" placeholder="Nome do produto">
    <input type="text" step = "1" id="cadastro_cod_barras" name="cod_barras" placeholder="código de barras" minlength="13" maxlength="13">
    <input type="number" step="0.01" name="valor" placeholder="Valor">
    <input type="number" step ="0.001" name="qt_estoque" placeholder="Quantidade">
    <button type="submit">Cadastrar</button>
</form>
<h2>Consultar produto por nome ou ID no banco de dados</h2>
<form method="POST" action="controllers/produtoController.php">
    <input type="hidden" name="acao" value="buscar_produto_nome_id_codBarras">
    <input type="text" name="nome_id_produto" placeholder="Nome/ID do produto">
    <button type="submit">Buscar</button>
</form>
<h2>Lançar unidades de um produto</h2>
<form method="POST" action="controllers/produtoController.php">
    <input type="hidden" name="acao" value="lancar_estoque_produto">
    <input type="number" step="1" name="id_produto" placeholder="ID do Produto">
    <input type="number" step = "0.001" name="qt_lancada" placeholder="Quantidade a lançar">
    <button type="submit">Lançar</button>
</form>
<h2>Editar dados de um produto</h2>
<form method="POST" action="controllers/produtoController.php">
    <input type="hidden" name="acao" value="editar_produto">
    <input type="number" step="1" name="id_produto" placeholder="ID do Produto">
    <input type="text" name="nome_produto" placeholder="nome">
    <input type="number" step = "0.001" name="qt_estoque" placeholder="estoque">
    <input type="number" step = "1" id="editar_cod_barras" name="cod_barras" placeholder="código de barras" minlength="13" maxlength="13">
    <input type="number" step = "0.01" name="valor_produto" placeholder="valor do produto">
    <input type="number" step = "1" name="status_produto" placeholder="status do produto" maxlength="1">
    <button type="submit">Confirmar</button>
</form>
<h1>Simular venda</h1>
<form method="POST" action="controllers/vendaController.php">
    <button type="submit">Confirmar</button>
</form>


<script>
    let cadastro_cod_barras = document.getElementById("cadastro_cod_barras");
    let editar_cod_barras = document.getElementById("editar_cod_barras");
    let LIMITE_CARACTERES_COD_BARRAS = 13;


    function limitarCaracteresInput(event) {
        let inputValue = this.value; 
        if (inputValue.length > LIMITE_CARACTERES_COD_BARRAS) {
            this.value = inputValue.substring(0, LIMITE_CARACTERES_COD_BARRAS);
        }
    }
    if (cadastro_cod_barras) {
        cadastro_cod_barras.addEventListener("keyup", limitarCaracteresInput);
    }

    if (editar_cod_barras) {
        editar_cod_barras.addEventListener("keyup", limitarCaracteresInput);
    }
</script>