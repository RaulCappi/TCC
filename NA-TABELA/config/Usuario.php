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

        $query = "INSERT INTO usuario (usu_nome, usu_email, usu_senha, usu_telefone, usu_estado, usu_cidade, usu_publicar, usu_ativo, created) VALUES (:nome, :email, :senha, :telefone, :estado, :cidade, 0, 1, NOW())";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':email', $this->formData['email']);
        $add->bindParam(':senha', $senhaCriptografada);
        $add->bindParam(':telefone', $this->formData['telefone']);
        $add->bindParam(':estado', $this->formData['estado']);
        $add->bindParam(':cidade', $this->formData['cidade']);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }

    }

    public function usuarioExiste(): bool
    {
        $this->conn = $this->conectar();
        $query = "SELECT COUNT(*) FROM usuario WHERE usu_nome = :nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->formData['nome']);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function emailExiste(): bool
    {
        $this->conn = $this->conectar();
        $query = "SELECT COUNT(*) FROM usuario WHERE usu_email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->formData['email']);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
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

    public function viewFoto(): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT usu_foto FROM usuario WHERE usu_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $result->execute();
        $valor = $result->fetch();
        return $valor;

    }

    public function edit(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_nome = :nome,
                                    usu_email = :email,
                                    usu_telefone = :telefone,
                                    usu_estado = :estado,
                                    usu_cidade = :cidade 
                                    WHERE usu_codigo = :id";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':email', $this->formData['email']);
        $add->bindParam(':telefone', $this->formData['telefone']);
        $add->bindParam(':estado', $this->formData['estado']);
        $add->bindParam(':cidade', $this->formData['cidade']);
        $add->bindParam(':id', $this->id);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }


    }

    public function editFoto($foto): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_foto = :foto WHERE usu_codigo = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteFoto(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_foto = null WHERE usu_codigo = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desativarUsuario(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_ativo = 0 WHERE usu_codigo = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
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

        $query = "SELECT usu_codigo, usu_nome, usu_senha, usu_ativo, usu_publicar FROM usuario WHERE usu_email = :email AND usu_nome = :nome AND usu_ativo = 1";
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
                $_SESSION['usu_ativo'] = $usuario['usu_ativo'];
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
        
    }

    public function loginAdm(): bool
    {
        $this->conn = $this->conectar();

        $query = "SELECT adm_codigo, adm_nome, adm_senha FROM Adm WHERE adm_nome = :nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->formData['nome']);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $adm = $stmt->fetch(PDO::FETCH_ASSOC);
            $senha_hash = $adm['adm_senha'];

            if (password_verify($this->formData['senha'], $senha_hash)) {
                // Login bem-sucedido
                $_SESSION['adm_codigo'] = $adm['adm_codigo'];
                $_SESSION['adm_nome'] = $adm['adm_nome'];
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
        
    }

    public function ativarUsu($ativo): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_ativo = :ativo WHERE usu_codigo = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function permitirUsu($perm): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE usuario SET usu_publicar = :perm WHERE usu_codigo = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':perm', $perm);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }


}