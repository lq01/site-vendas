<?php
//TODO: posteriormente, remover os 'echo's do codigo
class Produto {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function cadastrar($nome, $cod_barras, $valor, $qt_estoque) {
        $stmt = $this->conn->prepare("INSERT INTO produtos (nome, codigo_barras, valor, qt_estoque) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdd", $nome, $cod_barras, $valor, $qt_estoque); // s = string, d = double, i = int

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarID($id_produto){
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id_produto = ?");
        $stmt->bind_param("i", $id_produto);
        
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $produto = $resultado->fetch_assoc();
            return $produto;
        } else {
            return false;
        }
    }
    public function buscarNome($termo_busca){
        $termo_busca_curingas = '%' . $termo_busca .'%'; //"curingas" é o nome dado a esses '%' 
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE nome LIKE ?");
        $stmt->bind_param("s", $termo_busca_curingas);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
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
    
    public function editarProduto($id_produto, $cod_barras, $nome, $qt_estoque, $valor, $status){
    if (empty($id_produto) || !is_numeric($id_produto) || $id_produto <= 0) {
        echo "Digite o ID de produto para fazer modificações";
        return false;
    }
    $id_produto = (int)$id_produto;
    $success = true;


    if (!empty($cod_barras) && (strlen((string)$cod_barras) === 13)) {
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
} //TODO: front-end verifica se nenhum campo está vazio

}   
?>