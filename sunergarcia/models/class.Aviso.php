<?php
ini_set('display_errors', 1);
include_once("class.Database.php");


class Aviso

{

    public $id;
    public $titulo;
    public $contenido;


    public function __construct($id)

    {

        if(!is_null($id))

        {

            $db = new Database;

            $query = "SELECT * FROM avisos WHERE id = '$id' LIMIT 1";

            $avisos = $db->querySelect($query);

           // print_r($avisos); die();

            $avisos = $avisos[0];

            $this->fill_object($avisos);



        }

    }



    function fill_object(array $vars)

    {

        $has = get_object_vars($this);

        foreach ($has as $name => $oldValue) {

            $this->$name = isset($vars[$name]) ? $vars[$name] : NULL;

        }

        return $this;

    }



    function insert()

    {

        $db = new Database;

        $query = "INSERT INTO avisos SET
        
         id         = :id,
		 titulo 	= :titulo,
		 contenido     = :contenido";

        $has = get_object_vars($this);
        $array=array();
        foreach ($has as $name => $oldValue) {
            $array[$name]=isset($this->$name) ? $this->$name : NULL;
        }

        //print_r($query); print_r($array); die();

        $id = $db->queryUpdatePrepare($query,$array);

        if($id != -1){
            return $id;
        }else{
            return 0;
        }

    }



    function delete()

    {

        $db = new Database;

        $query = "DELETE FROM avisos WHERE id ='$this->id'";

        if ($db->queryUpdate($query) != -1){
            return 1;
        }else{
            return 0;
        }

    }



    function update()

    {

        $db = new Database;

        $query = "UPDATE avisos SET
                    titulo = '$this->titulo',
                    contenido =  '$this->contenido'
                    WHERE id= $this->id";

        //print_r($query); die();

        if ($db->queryUpdate($query) != -1){
            return 1;
        }else{
            return 0;
        }

    }


    static function getList()

    {

        $db = new Database;

        $query = "SELECT * FROM avisos";
        //print_r($query); die();
        $result= $db->querySelect($query);

        $avisos=array();

        foreach ($result as $aviso) {

            $avisosObj = new Aviso($aviso['id']);


            $avisos[] = $avisosObj;

        }

        return $avisos;

    }



}



?>