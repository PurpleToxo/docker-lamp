<?php
    require_once('../login/sesiones.php');
    require_once('../utils.php');
    require_once ('../modelo/entity/claseTareas.php');

    $tarea = new Tarea();
    $tarea->id = $_POST['id'];
    $tarea->titulo = $_POST['titulo'];
    $tarea->descripcion = $_POST['descripcion'];
    $tarea->estado = $_POST['estado'];
    $tarea->id_usuario = $_POST['id_usuario'];

    $response = 'error';
    $messages = array();

    $error = false;

    $location = 'editaTareaForm.php?id=' . $tarea->id;

    if (!checkAdmin()) $tarea->id_usuario = $_SESSION['usuario']['id'];

    //verificar titulo
    if (!validarCampoTexto($tarea->titulo)){
        $error = true;
        array_push($messages, 'El campo titulo es obligatorio y debe contener al menos 3 caracteres.');
    }
    //verificar descripcion
    if (!validarCampoTexto($tarea->descripcion)){
        $error = true;
        array_push($messages, 'El campo descripcion es obligatorio y debe contener al menos 3 caracteres.');
    }
    //verificar estado
    if (!validarCampoTexto($tarea->estado)){
        $error = true;
        array_push($messages, 'El campo estado es obligatorio.');
    }
    //verificar id_usuario
    if (!esNumeroValido($tarea->id_usuario)){
        $error = true;
        array_push($messages, 'El campo usuario es obligatorio.');
    }

    if (!$error){
        require_once('../modelo/mysqli.php');
        $resultado = actualizaTarea($tarea->id, filtraCampo($tarea->titulo), filtraCampo($tarea->descripcion), filtraCampo($tarea->estado), $tarea->id_usuario);
        if ($resultado[0]){
            $response = 'success';
            array_push($messages, 'Tarea actualizada correctamente.');
            $location = 'tareas.php';
        }else{
            $response = 'error';
            array_push($messages, 'Ocurrió un error actualizando la tarea: ' . $resultado[1] . '.');
        }
    }

    $_SESSION['status'] = $response;
    $_SESSION['messages'] = $messages;

    header("Location: $location");
?>                  