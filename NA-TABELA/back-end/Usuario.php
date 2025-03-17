<?php
class Usuario extends Conn
{
    public object $conn;
    public array $formData;
    public int $id;

    public function list(): array
    {
        $this->conn = $this->conectar();

        $query = "SELECT * FROM usuario";
        $result = $this->conn->prepare($query);
        $result->execute();
        $retorno = $result->fetchAll();
        return $retorno;
    }

    public function create(): bool
    {
        $this->conn = $this->conectar();
        $senha = $this->formData['senha'];
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuario (usu_nome, usu_email, usu_senha, usu_telefone, usu_cidade, usu_publicar, created) VALUES (:nome, :email, :senha, :telefone, :cidade, 0, NOW())";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':email', $this->formData['email']);
        $add->bindParam(':senha', $senhaCriptografada);
        $add->bindParam(':telefone', $this->formData['telefone']);
        $add->bindParam(':cidade', $this->formData['cidade']);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }

    }

    public function autorizacao($usu_codigo): mixed
    {
        $this->conn = $this->conectar();
        $sql = "SELECT usu_publicar FROM usuario WHERE usu_codigo = :usu_codigo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usu_codigo', $usu_codigo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && $usuario['usu_publicar'] != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function view(): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT * FROM usuario WHERE usu_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $result->execute();
        $valor = $result->fetch();
        return $valor;

    }

    public function edit(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET nome = :nome,
                                     email = :email
                                     senha = :senha
                                     telefone = :telefone
                                    WHERE usu_codigo = :id";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':email', $this->formData['email']);
        $add->bindParam(':senha', $this->formData['senha']);
        $add->bindParam(':telefone', $this->formData['telefone']);
        $add->bindParam(':id', $this->formData['id']);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }


    }

    public function delete(): bool
    {

        $this->conn = $this->conectar();
        $query = "DELETE FROM usuario WHERE usu_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $valor = $result->execute();
        return $valor;
    }

    public function login(): bool
    {
        $this->conn = $this->conectar();

        $query = "SELECT usu_codigo, usu_nome, usu_senha FROM usuario WHERE usu_email = :email AND usu_nome = :nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->formData['email']);
        $stmt->bindParam(':nome', $this->formData['nome']);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $senha_hash = $usuario['usu_senha'];

            if (password_verify($this->formData['senha'], $senha_hash)) {
                // Login bem-sucedido
                $_SESSION['usu_codigo'] = $usuario['usu_codigo'];
                $_SESSION['usu_nome'] = $usuario['usu_nome'];
                $_SESSION['usu_publicar'] = $usuario['usu_publicar'];
                return true;
            } else {
                //echo "<h4 style='text-align: center'>Login/Senha incorretos.</h4>";
                return false;
            }
        } else {
            /*$_SESSION['msg_erro1'] =
                "<h5 style='color: red; text-align: center'>Usuário não encontrado!</h5>";*/

            return false;
        }
    }

}