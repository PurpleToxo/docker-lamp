<?php
require_once('../login/sesiones.php');
require_once('../modelo/entity/claseUsuario.php');
if (!checkAdmin()) redirectIndex();

$message = 'Error borrando el usuario.';
$error = true;

require_once('../modelo/pdo.php');

if (!empty($_GET['id'])){
    $usuario = new User();
    $id = $_GET['id'];

    if($usuario->buscarUsuario($id)){
        if($usuario->borrarUsuario()){
            $message = 'Usuario borrado correctamente.';
            $error = false;
        }else{
            $message = 'No se pudo borrar el usuario.';
        }
    }else{
        $message = 'No se pudo recuperar la información del usuario.';
    }

}
else{
    $message = 'Debes acceder a través del listado de usuarios.';
}

$status = $error ? 'error' : 'success';
header("Location: usuarios.php?status=$status&message=$message");
