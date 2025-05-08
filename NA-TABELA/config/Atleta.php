<?php
class Atleta extends Conn
{
    public object $conn;
    public array $formData;
    public int $id;

    public function list(): array
    {
        $this->conn = $this->conectar();

        $query = "SELECT * FROM atleta";
        $result = $this->conn->prepare($query);
        $result->execute();
        $retorno = $result->fetchAll();
        return $retorno;
    }

    public function create($arquivo): bool
    {
        $this->conn = $this->conectar();

        $query = "INSERT INTO atleta (atl_nome, atl_idade, atl_cidade, atl_foto) VALUES (:nome, :idade, :cidade, :foto)";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':idade', $this->formData['idade']);
        $add->bindParam(':cidade', $this->formData['cidade']);
        $add->bindParam(':foto', $arquivo);
        $add->execute();

        if ($add->rowCount()) {
            return true;
        } else {
            return false;
        }

    }

    public function view($limite, $inicio): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT * FROM atleta WHERE atl_idade <= :limite AND atl_idade >= :inicio";
        $result = $this->conn->prepare($query);
        $result->bindParam(':limite', $limite);
        $result->bindParam(':inicio', $inicio);
        $result->execute();
        $valor = $result->fetchAll();
        return $valor;

    }

    public function viewIndividual(): mixed
    {
        $this->conn = $this->conectar();
        $query = "SELECT * FROM atleta WHERE atl_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $result->execute();
        $valor = $result->fetch();
        return $valor;

    }


    public function edit(): bool
    {
        $this->conn = $this->conectar();
        $query = "UPDATE atleta SET atl_nome = :nome,
                                    atl_idade = :idade,
                                    atl_cidade = :cidade
                                    WHERE atl_codigo = :id";
        $add = $this->conn->prepare($query);
        $add->bindParam(':nome', $this->formData['nome']);
        $add->bindParam(':idade', $this->formData['idade']);
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
        $query = "UPDATE atleta SET atl_foto = :foto WHERE atl_codigo = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(): bool
    {

        $this->conn = $this->conectar();
        $query = "DELETE FROM atleta WHERE atl_codigo = :id LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->bindParam(':id', $this->id);
        $valor = $result->execute();
        return $valor;
    }

}