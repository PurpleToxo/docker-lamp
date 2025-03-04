<?php
require_once('../login/sesiones.php');
require_once ('../modelo/entity/claseUsuario.php');
if (!checkAdmin()) redirectIndex();
    
require_once('../utils.php');
$usuario = new User();
$usuario->nombre = $_POST['nombre'];
$usuario->apellidos = $_POST['apellidos'];
$usuario->username = $_POST['username'];
$usuario->contrasena = $_POST['contrasena'];
$usuario->rol = $_POST['rol'];
$error = false;

$message = 'Error creando el usuario.';

//verificar nombre
if (!validarCampoTexto($usuario->nombre)){
    $error = true;
    $message = 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.';
}
//verificar apellidos
if (!$error && !validarCampoTexto($usuario->apellidos)){
    $error = true;
    $message = 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.';
}
//verificar username
if (!$error && !validarCampoTexto($usuario->username)){
    $error = true;
    $message = 'El campo username es obligatorio y debe contener al menos 3 caracteres.';
}
//verificar contrasena
if (!$error && !validaContrasena($usuario->contrasena)){
    $error = true;
    $message = 'El campo contraseña es obligatorio y debe ser compleja.';
}
if (!$error){
    require_once('../modelo/pdo.php');
    $resultado = nuevoUsuario(filtraCampo($usuario->nombre), filtraCampo($usuario->apellidos), filtraCampo($usuario->username), $usuario->contrasena, $usuario->rol);
    if ($resultado[0]){
        $message = 'Usuario guardado correctamente.';
    }
    else{
        $message = 'Ocurrió un error guardando el usuario: ' . $resultado[1];
        $error = true;
    }
}

$status = $error ? 'error' : 'success';
header("Location: nuevoUsuarioForm.php?status=$status&message=$message");

