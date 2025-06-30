<?php
//TODO: posteriormente, remover os 'echo's do codigo
class Produto {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function cadastrar($nome, $cod_barras, $valor, $qt_estoque, $imagem) {
        $nullBlob = null;
        $stmt = $this->conn->prepare("INSERT INTO produtos (nome, codigo_barras, valor, qt_estoque, imagem) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdib", $nome, $cod_barras, $valor, $qt_estoque, $nullBlob);
        if (!$imagem == null){
            $stmt->send_long_data(4, $imagem); //indice 4 quer dizer posicao 5
            }
            
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function buscarID($id_produto){
        $stmt = $this->conn->prepare("SELECT id_produto, nome, codigo_barras, valor, qt_estoque FROM produtos WHERE id_produto = ?");
        $stmt->bind_param("i", $id_produto);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $produto = $resultado->fetch_assoc();

            return $produto ? [$produto] : [];
        }

        return [];
    }

    public function buscarNome($termo_busca){
        $termo_busca_curingas = '%' . $termo_busca .'%';
        $stmt = $this->conn->prepare("SELECT id_produto, nome, codigo_barras, valor, qt_estoque FROM produtos WHERE nome LIKE ?");
        $stmt->bind_param("s", $termo_busca_curingas);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function buscarCodBarras($termo_busca){
        $termo_busca_curingas = '%' . $termo_busca .'%';
        $stmt = $this->conn->prepare("SELECT id_produto, nome, codigo_barras, valor, qt_estoque FROM produtos WHERE codigo_barras LIKE ?");
        $stmt->bind_param("s", $termo_busca_curingas);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
    public function lancarEstoque($id_produto, $qt_estoque_lancado){
        $stmt = $this->conn->prepare("UPDATE produtos SET qt_estoque = qt_estoque + ? WHERE id_produto = ?");
        $stmt->bind_param("di", $qt_estoque_lancado, $id_produto);
        $execucao = $stmt->execute();

        if ($execucao && $stmt->affected_rows > 0) {
            return true; 
        } else if ($stmt->affected_rows === 0) {
            echo "Erro ao adicionar estoque: nenhum valor foi adicionado";
            return false;
        }
        else {
            echo "Erro ao adicionar estoque: ID de produto não encontrada." ;
            return false; 
        }
    }  
    public function editarProduto($id_produto, $cod_barras, $nome, $qt_estoque, $valor, $imagem, $status){
    if (empty($id_produto) || !is_numeric($id_produto) || $id_produto <= 0) {
        echo "Digite o ID de produto para fazer modificações";
        return false;
    }
    $id_produto = (int)$id_produto;
    $success = true;

    if (strlen((string)$cod_barras) === 13 || strlen((string)$cod_barras) === 0) {
        $stmt = $this->conn->prepare("UPDATE produtos SET codigo_barras = ? WHERE id_produto = ?");
        $stmt->bind_param("si", $cod_barras, $id_produto);
        if (!$stmt->execute()) {
            $success = false;
            error_log("Erro ao atualizar codigo_barras: " . $stmt->error);
        }
        $stmt->close();
    }
    if (!empty($nome)) {
        $stmt = $this->conn->prepare("UPDATE produtos SET nome = ? WHERE id_produto = ?");
        $stmt->bind_param("si", $nome, $id_produto);
        if (!$stmt->execute()) {
            $success = false;
            error_log("Erro ao atualizar nome: " . $stmt->error);
        }
        $stmt->close();
    }
    if (!empty($qt_estoque) || $qt_estoque == 0) {
        if (is_numeric($qt_estoque)) {
            $qt_estoque = (int)$qt_estoque;
            $stmt = $this->conn->prepare("UPDATE produtos SET qt_estoque = ? WHERE id_produto = ?");
            $stmt->bind_param("ii", $qt_estoque, $id_produto);
            if (!$stmt->execute()) {
                $success = false;
                error_log("Erro ao atualizar qt_estoque: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("qt_estoque inválido: " . $qt_estoque);
            $success = false;
        }
    }
    if (!empty($valor) || $valor == 0.0) {
        if (is_numeric($valor)) {
            $valor = (float)$valor;
            $stmt = $this->conn->prepare("UPDATE produtos SET valor = ? WHERE id_produto = ?");
            $stmt->bind_param("di", $valor, $id_produto);
            if (!$stmt->execute()) {
                $success = false;
                error_log("Erro ao atualizar valor: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Valor inválido: " . $valor);
            $success = false;
        }
    }
    if (!empty($imagem) && $imagem != null) {
        $nullBlob = null;
        $stmt = $this->conn->prepare("UPDATE produtos SET imagem = ? WHERE id_produto = ?");
        $stmt->bind_param("bi", $nullBlob, $id_produto);
        $stmt->send_long_data(0, $imagem);
        if (!$stmt->execute()) {
            $success = false;
            error_log("Erro ao atualizar imagem:". $stmt->error);
        }
        $stmt->close();
    }
    if (!empty($status) || $status == 0) {
        if (is_numeric($status)) {
            $status = (int)$status;
            $stmt = $this->conn->prepare("UPDATE produtos SET `status` = ? WHERE id_produto = ?");
            $stmt->bind_param("ii", $status, $id_produto);
            if (!$stmt->execute()) {
                $success = false;
                error_log("Erro ao atualizar status: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Status inválido: " . $status);
            $success = false;
        }
    }
    return $success;
    }
    public function obterImagem($id_produto) {
    $stmt = $this->conn->prepare("SELECT imagem FROM produtos WHERE id_produto = ?");
    $stmt->bind_param("i", $id_produto);
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        if ($row = $resultado->fetch_assoc()) {
            return $row['imagem'];
        }
    }
    return null;
}
    }
    //TODO: INDAGAÇÃO: Devo criar uma função obterProduto($id_produto) que retorne o produto completo, e exatamente o produto buscado, ou seja, com todos os atributos?

