<?php
require_once '../includes/db.php';
require_once '../model/Produto.php';
class Venda {
    private $conn;
    private $lista_produtos;
    private $venda_aberta;
    private $produto_buscado;
    private $valor_venda;
    private $metodo_pagamento;

    public function __construct($conexao) {
        $this->conn = $conexao;
        $this->lista_produtos = [];
        $this->venda_aberta = false;
        $this->produto_buscado = new Produto($this->conn);
        $this->valor_venda = 0.00;
        $this->metodo_pagamento = '';
    }

    public function abrirVenda() {//função que abre uma lista para adicionar produtos a venda
        $this->venda_aberta = true;
        $this->lista_produtos = [];
        $this->metodo_pagamento = '';
        $this->valor_venda = 0.00;
        return true;
    }
    public function fecharVenda() {
        if (!$this->venda_aberta) {
            echo "Venda não aberta. Abra uma venda antes de fechá-la.";
            return false;
        }
        if (empty($this->lista_produtos)) {
            echo "Nenhum produto adicionado à venda. Adicione produtos antes de fechar a venda.";
            return false;
        }
        if ($this->metodo_pagamento == '') {
            echo "Método de pagamento não definido. Defina um método de pagamento antes de fechar a venda.";
            return false;
        }
        $this->venda_aberta = false;
        return true;
    }
    public function registrarVenda($metodo_pagamento) {
        if ($this->venda_aberta) {
            echo "A venda ainda está aberta. Feche-a antes de registrá-la.";
            return false;
        }
        $this->valor_venda = 0.00;
        foreach ($this->lista_produtos as $produto) {
            $this->valor_venda += $produto['subtotal_produto'];
        }
        $this->metodo_pagamento = strtoupper($metodo_pagamento);
        $stmt = $this->conn->prepare("INSERT INTO vendas (valor_venda, metodo_pagamento, produtos_vendidos) VALUES (?, ?, ?)");
        $stmt->bind_param("dss", $this->valor_venda, $this->metodo_pagamento, json_encode($this->lista_produtos));
        $stmt->execute();
        return true;
    }
    public function adicionarProduto($id_produto, $qt_vendida) {
        if (!$this->venda_aberta) {
            echo "Venda não aberta. Abra uma venda antes de adicionar produtos.";
            return false;
        }
        $produto = $this->produto_buscado->buscarID($id_produto);

        if ($this->lista_produtos != null){ //Atualiza a quantidade vendida se o produto já estiver na lista
            foreach ($this->lista_produtos as &$produto_existente) {
                if ($produto_existente['id_produto'] == $id_produto) {
                    $produto_existente['qt_vendida'] += $qt_vendida; 
                    $produto_existente['subtotal_produto'] = $produto_existente['valor'] * $produto_existente['qt_vendida'];
                    return true;
                }
            }
        } else if ($produto) {
            if ($qt_vendida <= 0) {
                echo "Quantidade vendida deve ser maior que zero.";
                return false;
            }
            if ($qt_vendida > $produto['qt_estoque']) {
                echo "Quantidade vendida maior que a quantidade em estoque.";
                return false;
            }
            $id = $produto['id_produto'];
            $nome = $produto['nome'];
            $cod_barras = $produto['codigo_barras'];
            $valor = $produto['valor'];
            $this->lista_produtos[] = [
                'id_produto' => $id,
                'nome' => $nome,
                'cod_barras' => $cod_barras,
                'valor' => $valor,
                'qt_vendida' => $qt_vendida,
                'subtotal_produto' => $valor * $qt_vendida
            ];
            return true;
        } else {
            echo "Produto não encontrado.";
            return false;
        }
    }
    public function removerProduto($id_produto) {
        if (!$this->venda_aberta) {
            echo "Venda não aberta. Abra uma venda antes de remover produtos.";
            return false;
        }
        foreach ($this->lista_produtos as $key => $produto) {
            if ($produto['id_produto'] == $id_produto) {
                unset($this->lista_produtos[$key]);
                return true;
            }
        }
        echo "Produto não encontrado na lista de venda.";
        return false;
    }
    public function removerQtProduto($id_produto, $qt_removida) {
        if (!$this->venda_aberta) {
            echo "Venda não aberta. Abra uma venda antes de remover produtos.";
            return false;
        }
        foreach ($this->lista_produtos as $key => $produto) {
            if ($produto['id_produto'] == $id_produto) {
                if ($qt_removida >= $produto['qt_vendida']) {
                    unset($this->lista_produtos[$key]);
                } else {
                    $produto['qt_vendida'] -= $qt_removida;
                    $produto['subtotal_produto'] = $produto['valor'] * $produto['qt_vendida'];
                    $this->lista_produtos[$key] = $produto;
                }
                $this->lista_produtos = array_values($this->lista_produtos);
                return true;
            }
        }
        echo "Produto não encontrado na lista de venda.";
        return false;
    }
}