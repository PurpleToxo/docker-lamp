<?php
// Variable global para almacenar las tareas
$tasks = [];

/**
 * Devolver listado de tareas.
 *
 * @return array
 */
function getTasks() {
    global $tasks;
    return $tasks;
}

/**
 * Filtrar el contenido de un campo.
 *
 * @param string $input
 * @return string
 */
function filterInput($input) {
    // Eliminar caracteres especiales y espacios en blanco duplicados
    $input = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚüÜñÑ\s]/u', '', $input); // Permitir solo letras, números y espacios
    $input = preg_replace('/\s+/', ' ', trim($input)); // Eliminar espacios duplicados
    return $input;
}

/**
 * Comprobar que un campo contiene información de texto válida.
 *
 * @param string $input
 * @return bool
 */
function isValidText($input) {
    $filteredInput = filterInput($input);
    // Comprobar que el texto no está vacío
    return !empty($filteredInput);
}

/**
 * Guardar una tarea.
 *
 * @param string $titulo
 * @param string $descripcion
 * @param string $estado
 * @return bool
 */
function saveTask($titulo, $descripcion, $estado) {
    global $tasks;

    // Filtrar y validar los campos
    $titulo = filterInput($titulo);
    $descripcion = filterInput($descripcion);
    $estado = filterInput($estado);
    
    $validStatuses = ['pendiente', 'en proceso', 'completada'];

    if (isValidText($titulo) && isValidText($descripcion) && in_array($estado, $validStatuses)) {
        // Crear una nueva tarea
        $task = [
            'Titulo de la tarea' => $titulo,
            'Descripcion' => $descripcion,
            'Estado' => $estado
        ];

        // Agregar la tarea al array global
        $tasks[] = $task;
        return true; // Simulando que se guarda
    }

    return false; // No se valida algún campo
}
?>
