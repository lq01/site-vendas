<?php
Class Usuario {
    private $conn;
    private $permission;

    public function __construct($conexao) {
        $this->conn = $conexao;
        $this->permission = "";
    }
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                if ($username === 'admin') {
                    $this->permission = 'admin';
                } else {
                    $this->permission = 'user';
                }
                return true; // Login bem-sucedido
            } else {
                return false; // Credenciais inválidas
            }
        } else {
            return false; 
        }
    }
    public function isAdmin(){
        if ($this->permission === 'admin') {
            return true;
        } else {
            return false;
        }
    }

}