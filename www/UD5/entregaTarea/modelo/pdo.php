<?php

function conectaPDO(){
    $servername = $_ENV['DATABASE_HOST'];
    $username = $_ENV['DATABASE_USER'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $dbname = $_ENV['DATABASE_NAME'];

    $conPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conPDO;
}

function listaUsuarios(){
    try {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, username, nombre, apellidos, rol, contrasena FROM usuarios');
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultados = [];

        foreach($result as $usuario){
            $user = new User();

            $user -> setId($usuario['id']);
            $user -> setUsername($usuario['username']);
            $user -> setName($usuario ['name']);
            $user -> setApellidos($usuario ['apellidos']);
            $user -> setContrasena($usuario ['contrasena']);
            $user -> setRol($usuario ['rol']);

            $resultados []= $user;
        }
        return [true, $resultados];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
}

function listaTareasPDO($id_usuario, $estado){
    try {
        $con = conectaPDO();
        $sql = 'SELECT * FROM tareas WHERE id_usuario = ' . $id_usuario;
        if (isset($estado)){
            $sql = $sql . " AND estado = '" . $estado . "'";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $tareas = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){  //con esto iteramos en cada fila generando varios objetos
            //Buscamos usuario
            $usuario = buscaUsuario($row['id_usuario']);
            $row['id_usuario'] = $usuario['username'];
            //creamos objeto de clase tarea
            $tarea = new Tarea();
            $tarea -> setId($row['id']);
            $tarea -> setTitulo($row['titulo']);
            $tarea -> setDescripcion($row['descripcion']);
            $tarea -> setEstado($row['estado']);
            $tarea -> setIdUsuario($row['id_usuario']);
            //añadimos cada tarea al array
            $tareas [] = $tarea;
        }
        return [true, $tareas];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
    
}

function nuevoUsuario($usuario){
    try{
        $con = conectaPDO();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, username, rol, contrasena) VALUES (:nombre, :apellidos, :username, :rol, :contrasena)");
        
        $stmt->bindParam(':nombre', $usuario->getName());
        $stmt->bindParam(':apellidos', $usuario->getApellidos());
        $stmt->bindParam(':username', $usuario->getUsername());
        $stmt->bindParam(':rol', $usuario->getRol());
        $hasheado = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $hasheado);
        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function actualizaUsuario($usuario){
    try{
        $con = conectaPDO();
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, username = :username, rol = :rol";

        if (isset($contrasena)){
            $sql = $sql . ', contrasena = :contrasena';
        }
        $sql = $sql . ' WHERE id = :id';

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $usuario->getName());
        $stmt->bindParam(':apellidos', $usuario->getApellidos());
        $stmt->bindParam(':username', $usuario->getUsername());
        $stmt->bindParam(':rol', $usuario->getRol());
        if (isset($contrasena)){
            $hasheado = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);
            $stmt->bindParam(':contrasena', $hasheado);
        }
        $stmt->bindParam(':id', $usuario->getId());

        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function borraUsuario($id) {  //Falta por cambiar a objetos
    try {
        $con = conectaPDO();

        $con->beginTransaction();

        $stmt = $con->prepare('DELETE FROM tareas WHERE id_usuario = ' . $id);
        $stmt->execute();
        $stmt = $con->prepare('DELETE FROM usuarios WHERE id = ' . $id);
        $stmt->execute();
        
        return [$con->commit(), ''];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function buscaUsuario($id){
    try{
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, username, nombre, apellidos, rol, contrasena FROM usuarios WHERE id = ' . $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1){
            $row = $stmt->fetch();
            $user = new User();
            $user -> setId($row['id']);
            $user -> setUsername($row['Username']);
            $user -> setName($row['name']);
            $user -> setApellidos($row['apellidos']);
            $user -> setContrasena($row['contrasena']);
            $user -> setRol($row['rol']);
        }
        else{
            return null;
        }
    }
    catch (PDOExcetion $e){
        return null;
    }
    finally{
        $con = null;
    }
}

function buscaUsername($username){
    try{
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, rol, contrasena FROM usuarios WHERE username = "' . $username . '"');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1){
            $row = $stmt->fetch();
            $user = new User();
            $user -> setId($row['id']);
            $user -> setUsername($row['Username']);
            $user -> setName($row['name']);
            $user -> setApellidos($row['apellidos']);
            $user -> setContrasena($row['contrasena']);
            $user -> setRol($row['rol']); 
        }
        else{
            return null;
        }
    }
    catch (PDOExcetion $e){
        return null;
    }
    finally{
        $con = null;
    }
}

function listaFicheros($id_tarea){
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
    catch (PDOException $e){
        return array();
    }
    finally{
        $con = null;
    }
}

function buscaFichero($id){
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
    catch (PDOException $e){
        return null;
    }
    finally{
        $con = null;
    }
}

function borraFichero($id){
    try
    {
        $con = conectaPDO();
        $sql = 'DELETE FROM ficheros WHERE id = ' . $id;
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return true;
    }
    catch (PDOException $e)
    {
        return false;
    }
    finally
    {
        $con = null;
    }
}

function nuevoFichero($fichero){
    try{
        $con = conectaPDO();
        $stmt = $con->prepare("INSERT INTO ficheros (nombre, file, descripcion, id_tarea) VALUES (:nombre, :file, :descripcion, :idTarea)");
        $stmt->bindParam(':file', $fichero->getFile());
        $stmt->bindParam(':nombre', $fichero->getNombre());
        $stmt->bindParam(':descripcion', $fichero->getDescripcion());
        $stmt->bindParam(':idTarea', $fichero->getIdTarea());
        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOExcetion $e) {
        return [false, $e->getMessage()];
    }
    finally{
        $con = null;
    }
}