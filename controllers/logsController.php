<?php

class LogsController
{
    private static $logFile = './logs/logsAcciones.log';

    // Función para crear un log
    public static function crearLog($accion, $detalle){
        $fecha = date('Y-m-d H:i:s');
        // Añadimos un salto de línea al final para que cada log se muestre en una línea separada
        $logMessage = "[$fecha] - ACCION: $accion - DETALLE: $detalle\n";

        // Escribir en el archivo de logs
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }


    // Función para mostrar todos los logs
    public static function mostrarLogs(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        if (file_exists(self::$logFile)) {
            $logs = file_get_contents(self::$logFile);
            $logArray = array_filter(explode("\n", trim($logs))); // Convertir los logs en un array y eliminar líneas vacías

            echo json_encode($logArray, JSON_PRETTY_PRINT);
        } else {
            http_response_code(404); // Asegurarse de devolver un código 404 si el archivo no existe
            echo json_encode(["error" => "El archivo de logs no existe."]);
        }
    }
}