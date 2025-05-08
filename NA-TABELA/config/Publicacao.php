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

    public function list(): array
    {
        $this->conn = $this->conectar();

        $query = "SELECT * FROM publicacao";
        $result = $this->conn->prepare($query);
        $result->execute();
        $retorno = $result->fetchAll();
        return $retorno;
    }

    public function totalPublicacoes(): int {
        $this->conn = $this->conectar();
        $query = "SELECT COUNT(*) FROM publicacao";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();

    }

    public function publicaoesPaginadas($paginaAtual, $postsPorPagina): mixed {
        $this->conn = $this->conectar();
        $offset = ($paginaAtual - 1) * $postsPorPagina;
        if ($offset < 0) {
            $offset = 0;

        }

        $query = "SELECT * FROM publicacao ORDER BY pub_codigo DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $postsPorPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function numeroTotalPaginas($postsPorPagina): int
    {
        $totalPosts = $this->totalPublicacoes();
        return ceil($totalPosts / $postsPorPagina);
    }

    public function viewList(): mixed
    {

        $this->conn = $this->conectar();
        $query = "SELECT * FROM publicacao ORDER BY pub_codigo DESC";//LIMIT $inicio, $this->maximo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
   
    public function viewIndividual(): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT * FROM publicacao WHERE pub_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $result->execute();
        $valor = $result->fetch();
        return $valor;

    }

    public function getNome($usuarioCodigo): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT usu_nome, usu_ativo FROM usuario WHERE usu_codigo = :usuario_codigo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_codigo', $usuarioCodigo, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario['usu_ativo'] == 0) {
            $usuario['usu_nome'] = "[Perfil deletado]";
            return $usuario['usu_nome'];
        }

        if ($usuario) {
            return $usuario['usu_nome'];
        } else {
            return "Usuário não encontrado"; // Ou outra mensagem apropriada
        }
    }

    public function getFoto($usuarioCodigo): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT usu_foto, usu_ativo FROM usuario WHERE usu_codigo = :usuario_codigo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_codigo', $usuarioCodigo, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario['usu_ativo'] == 0) {
            $usuario['usu_foto'] = null;
            return $usuario['usu_foto'];
        }

        if ($usuario) {
            return $usuario['usu_foto'];
        } else {
            return "Usuário não encontrado"; // Ou outra mensagem apropriada
        }
    }

    public function edit(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE publicacao SET pub_titulo = :titulo,
                                        pub_descricao = :descricao,
                                        modified =  CURDATE(),
                                        hora_modif = CURTIME()
                                        WHERE pub_codigo = :id";
        $add = $this->conn->prepare($query);
        $add->bindParam(':titulo', $this->formData['titulo']);
        $add->bindParam(':descricao', $this->formData['descricao']);
        
        $add->bindParam(':id', $this->id);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }


    }
    public function editConteudo($conteudo, $id): bool
{
    $this->conn = $this->conectar();
    $query = "UPDATE publicacao SET pub_conteudo = :conteudo WHERE pub_codigo = :id";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':conteudo', $conteudo);
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    return $stmt->execute();
}

    public function delete(): bool
    {

        $this->conn = $this->conectar();
        $query = "DELETE FROM publicacao WHERE pub_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $valor = $result->execute();
        return $valor;
    }

    public function pesquisarPub($pesquisa): array
    {
        $this->conn = $this->conectar();

        $query = "SELECT * FROM publicacao WHERE pub_titulo LIKE :pesquisa OR pub_descricao LIKE :pesquisa";
        $result = $this->conn->prepare($query);
        $termo = '%' . $pesquisa . '%';
        $result->bindParam(':pesquisa', $termo, PDO::PARAM_STR);
        $result->execute();
        $retorno = $result->fetchAll();
        return $retorno;
    }


}
