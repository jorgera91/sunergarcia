<?php
ini_set('display_errors', 1);
class Database
{
	
	
	function nuevaConexion()
    {
        $db_ip   = '127.0.0.1';
        $db_name = 'sunergarcia';
        $db_user = 'root';
        $db_pass = '';

        $conn = new PDO("mysql:host=$db_ip;dbname=$db_name", "$db_user", "$db_pass");
        return $conn;
    }
	
	 function querySelect($query)
    {

        try{
            $conn =$this->nuevaConexion();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query($query);
            if(empty($stmt)){
                $vacio = array();
                return $vacio;
            }else{
                $resultados = array();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $resultados[] = $row;
                }
                $stmt->closeCursor();
                $conn = null;
                //print_r($resultados);
                return $resultados;
            }
        }
        catch(PDOException $e){
            return "ERROR: " . $e->getMessage();
        }
    }

    function querySelectPrepare($query,$array)
    {
        try{
            $conn=$this->nuevaConexion();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $prep=$conn->prepare($query);
            //print_r($query);
            $res=$prep->execute($array);

            $resultados=array();

            $r=$prep->fetchAll(PDO::FETCH_ASSOC);

            foreach ($r as $row) {

                $resultados[] = $row;
            }

            $conn = null;
            return $resultados;
        }
        catch(PDOException $e){
            return $e;
            //	print_r($e);
        }
    }

    function queryUpdate($query)
    {
        try{
            $conn=$this->nuevaConexion();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query($query);
            $res = $conn->lastInsertId();
            if((empty($res)) || ($res == 0)){
                return 0;
            }else{
                return $conn->lastInsertId();
            }
        }
        catch(PDOException $e){
            return -1;
        }
    }

    function queryUpdatePrepare($query,$array)
    {
        try{
            $conn=$this->nuevaConexion();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql=$conn->prepare($query);
            $sql->execute($array);
            // $stmt = $conn->query($query);
            $res = $conn->lastInsertId();
            if(empty($res)){
                return true;
            }else{
                return $conn->lastInsertId();
            }
        }
        catch(PDOException $e){
            return $e;
        }
    }
	
}

?>