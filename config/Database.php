<?php
class Database
{
    //DB params
    private $host='localhost';
    private $db_name='myblog';
    private $username='root';
    private $password ='';
    private $pdo;

    public function connect()
    {
        $this->pdo=null;
        try {
            //'mysql:host=localhost;port=3306;dbname=myblog', 'root', ''
            $this->pdo= new PDO('mysql:host='.$this->host.';'.
            'dbname='.$this->db_name,$this->username,$this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: '.$e;
        }
        return $this->pdo;
    }
}