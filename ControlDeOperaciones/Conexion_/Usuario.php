<?php
class Usuario{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    function getLogin($datos){
        $R['estado'] = "OK";
       $c = $this->conn;
        
        try {
            $sql = $c ->prepare("SELECT * FROM usuario WHERE nombre = :User AND contrasena = AES_ENCRYPT(:Pass, :Clave)");
            $sql->execute(array("User" => $datos->user, "Pass" => $datos->pass, "Clave" => $datos->clave));            
            $R['filas'] = $sql->rowCount();
            if($R['filas'] > 0){
                $R['datos'] = $sql->fetchAll();
            }else{
                $R['estado'] = "usuario no encontrado";
            }
            $sql = null;
        } catch (PDOException $e) {
            $R['estado'] = "Error: " . $e->getMessage();
        }
        return $R;
        
    }
}
?>