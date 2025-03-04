<?php 
require_once 'FicherosDBInt';

class FicheroDBImp implements FicherosDBInt{

    public function listaFicheros($id_tareas){ //debe devolver un array
        try{
            $con = conectaPDO();
            $sql = 'SELECT * FROM ficheros WHERE id_tarea = ' . $id_tarea;
            $stmt = $con->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $ficheros = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){  //con esto iteramos en cada fila generando varios objetos
                //Buscamos usuario
                $tarea = buscaTarea($row['id_tarea']);
                $row['id_tarea'] = $tarea['titulo'];
                //creamos objeto de clase tarea
                $fichero = new Tarea();
                $fichero -> setId($row['id']);
                $fichero -> setTitulo($row['nombre']);
                $fichero -> setDescripcion($row['file']);
                $fichero -> setEstado($row['descripcion']);
                $fichero -> setIdUsuario($row['id_tarea']);
                //añadimos cada tarea al array
                $ficheros [] = $fichero;
            }
            return [true, $ficheros];
        }
        catch (DatabaseException $e) {
            echo 'Exception capturada: ', $e->getMessage(), "\n";
            echo 'Método SQL: ', $e->getMethod(), "\n";
            echo 'Sentencia SQL: ', $e->getSQL(), "\n";
        }
        finally{
            $con = null;
        }
    }

    public function buscaFicheros ($id){ // devuelve un fichero   
        try{
            $con = conectaPDO();
            $sql = 'SELECT * FROM ficheros WHERE id = ' . $id;
            $stmt = $con->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fichero = [];
            if($stmt->rowCount() == 1){
                $row = $stmt->fetch();
                $fichero = new Fichero();
                $fichero -> setId($row['id']);
                $fichero -> setNombre($row['nombre']);
                $fichero -> setFile($row['file']);
                $fichero -> setDescripcion($row['descripcion']);
                $fichero -> setIdTarea($row['id_tarea']);            
            }
            return $fichero;
        }
        catch (DatabaseException $e) {
            echo 'Exception capturada: ', $e->getMessage(), "\n";
            echo 'Método SQL: ', $e->getMethod(), "\n";
            echo 'Sentencia SQL: ', $e->getSQL(), "\n";
        }
        finally{
            $con = null;
        }
    }

    public function borrarFichero($id){ //devuelve boolean
        try{
            $con = conectaPDO();
            $sql = 'DELETE FROM ficheros WHERE id = ' . $id;
            $stmt = $con->prepare($sql);
            $stmt->execute();
    
            return true;
        }
        catch (DatabaseException $e) {
            echo 'Exception capturada: ', $e->getMessage(), "\n";
            echo 'Método SQL: ', $e->getMethod(), "\n";
            echo 'Sentencia SQL: ', $e->getSQL(), "\n";
        }
        finally{
            $con = null;
        }
    }

    public function nuevoFichero ($id){ //devuelve boolean
        try{
            $con = conectaPDO();
            $stmt = $con->prepare("INSERT INTO ficheros (nombre, file, descripcion, id_tarea) VALUES (:nombre, :file, :descripcion, :idTarea)");
            $stmt->bindParam(':file', $fichero->setFile());
            $stmt->bindParam(':nombre', $fichero->setNombre());
            $stmt->bindParam(':descripcion', $fichero->setDescripcion());
            $stmt->bindParam(':idTarea', $fichero->setIdTarea());
            $stmt->execute();
            
            $stmt->closeCursor();
    
            return [true, null];
        }
        catch (DatabaseException $e) {
            echo 'Exception capturada: ', $e->getMessage(), "\n";
            echo 'Método SQL: ', $e->getMethod(), "\n";
            echo 'Sentencia SQL: ', $e->getSQL(), "\n";
        }
        finally{
            $con = null;
        }
    }
}

?>