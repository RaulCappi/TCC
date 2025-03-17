<?php
class Conn {
    public $host ="localhost";
    public $user ="root";
    public $pass ="";
    public $dbname ="na_tabela";
    public $port = 3306;
    public $connect = null;

    public function conectar(): bool|PDO{
        try {
            //com porta
           // $this->connect = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname, $this->user, $this->pass);
            //sem porta
            $this->connect = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);


            //echo "Conexão realizada com sucesso!";
            return $this->connect;

        }
        catch (Exception $err) {
            echo "Erro: Conexão não realizada com sucesso! Erro gerado: " . $err;
            return false;

        }
    }
    

    
}