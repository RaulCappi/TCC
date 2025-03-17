<?php
class Publicacao extends Conn
{
    public object $conn;
    public array $formData;
    public int $id;


    public function create($usuarioCodigo, $arquivo): bool
    {
        $this->conn = $this->conectar();
        $query = "INSERT INTO publicacao (pub_titulo, pub_descricao, pub_conteudo, created, hora, Usuario_usu_codigo) VALUES (:titulo, :descricao, :conteudo, CURDATE(), CURTIME(), :usuario_codigo)";
        $add = $this->conn->prepare($query);
        $add->bindParam(':titulo', $this->formData['titulo']);
        $add->bindParam(':descricao', $this->formData['descricao']);
        $add->bindParam(':conteudo', $arquivo);
        $add->bindParam(':descricao', $this->formData['descricao']);
        $add->bindParam(':usuario_codigo', $usuarioCodigo, PDO::PARAM_INT);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }

    }


    public function viewList(): mixed
    {

        $this->conn = $this->conectar();
        $query = "SELECT * FROM publicacao ORDER BY pub_codigo DESC";//LIMIT $inicio, $this->maximo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getNome($usuarioCodigo): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT usu_nome FROM usuario WHERE usu_codigo = :usuario_codigo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_codigo', $usuarioCodigo, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            return $usuario['usu_nome'];
        } else {
            return "Usuário não encontrado"; // Ou outra mensagem apropriada
        }
    }

    public function edit(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE empresa SET titulo = :titulo,
                                        descricao = :descricao
                                        WHERE idempresa = :id";
        $add = $this->conn->prepare($query);
        $add->bindParam(':titulo', $this->formData['titulo']);
        $add->bindParam(':descricao', $this->formData['descricao']);
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
        $query = "DELETE FROM empresa WHERE idempresa = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $valor = $result->execute();
        return $valor;
    }

}
