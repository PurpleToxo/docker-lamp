<?php
class Fichero{

    //atributos
    private $id;
    private $nombre;
    private $file;
    private $descripcion;
    private $tarea;
    public $formatos = ['image/jpeg', 'image/png', 'application/pdf'];
    public $max_size = 20*1024*1024;

    //constructor
    function __constructor($id,$nombre,$file,$descripcion,$tarea){
        $this-> id = $id;
        $this->nombre=$nombre;
        $this->file=$file;
        $this->descripcion=$descripcion;
        $this->tarea=$tarea;
    }


    //Setters y getters
    function setId($id){
        $this->id=$id;
    }
    function getId(){
        return $this->id;
    }

    function setNombre($nombre){
        $this->nombre=$nombre;
    }
    function getNombre(){
        return $this->nombre;
    }

    function setFile($file){
        $this->file=$file;
    }
    function getFile(){
        return $this->file;
    }

    function setDescripcion($descripcion){
        $this->descripcion=$descripcion;
    }
    function getDescripcion(){
        return $this->descripcion;
    }

    function setTarea($tarea){
        $this->tarea=$tarea;
    }
    function getTarea(){
        return $this->tarea;
    }

    public static function validar($file,$formatos,$max_size){
        //creamos array para almacenar errores
        $errores=[];
        
        //Valida tamaño de archivo
        if($file['size']>$max_size){
            $errores ['tamaño'] = "Error con el tamaño del archivo, debe ser menor de 20 MB";
        }

        //Validamos formato
        $format = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($format,$formatos)){
            $errores['formato']="Error en el formato, el archivo deve ser .jpeg, .pnj o .pdf";
        }

        return $errores;

    }


}
?>