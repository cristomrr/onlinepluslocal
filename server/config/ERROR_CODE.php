<?php

/**
 * Clase con los códigos de error que serán vistos por los usuarios al generar un error y éstos los puedan enviar a los administradores para ir directos al problema sin dar detalles al usuario
 */
class ERROR_CODE
{
  /**
   * Error DataBase Connect 001
   * Error al obtener la conexión con la base de datos Mysql/MariaDB 
   */
  public const CONNECT_DB = '#EDBC001';

  /**
   * Mensaje que será visualizado en la página de error 
   *
   * @param string $codeError Código de error de esta misma clase
   * @return string Mensaje con etiquetas HTML strong y br en las zonas necesarias. 
   */
  public static function setError(string $codeError): string
  {
    return
      'Hubo un error al realizar la solicitud, si el error persiste, contacte con el administrador del 
      sitio en la página de contacto enviando el código de error <strong>' . $codeError . '</strong> e 
      intentaremos solucionarlo lo antes posible. <br> Disculpe las molestias';
  }
}
