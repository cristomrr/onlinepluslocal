<?php

/**
 *  Clase encargada de almacenar las variables con información sensible, para no
 * ser enviada al repositorio o contenido utilizado en varias partes del proyecto
 * como imágenes. El archivo original debe ser ENV.php y nombre de la clase ENV
 */
class ENV_Example
{
  // RUTAS A IMÁGENES
  public const LOGO = '../server/assets/img/logo.png';
  public const IMG_GIRL = '../server/assets/img/girl.png';

  // EMAIL
  public const EMAIL_ACCOUNT = "onlinepluslocal@cmrr.es";
  public const EMAIL_PASSWORD = "";

  // DATABASE MARIADB
  public const DATABASE_NAME = 'onlinepluslocal';
  public const DATABASE_HOST = '127.0.0.1';

  // Configuración local:
  public const DATABASE_USER = '';
  public const DATABASE_PASSWORD = '';
  public const DATABASE_PORT = '';

  // Configuración servidor:
  // public const DATABASE_USER = '';
  // public const DATABASE_PASSWORD = '';
  // public const DATABASE_PORT = ; 

  /**
   * Salto para la encriptación de las contraseñas en la DB
   */
  public const SALT_PASSWD = '';

  /**
   * Ruta a cada página del sitio web desde el directorio raíz
   */
  public const ROUTE = [
    'home' => '',
    'login' => '/iniciar-sesion',
    'signup-seller' => '/registro-empresa',
    'signup-buyer' => '/registro-cliente',
    'contact' => '/contacto',
    'search' => '/buscador',
    'favorites' => '/favoritos',
    'userdata' => '/perfil',
  ];

  /**
   * Genera la URL del servidor donde está cargado el proyecto con el protocolo. Pudiendo ser: 
   * https://onlinepluslocal.cmrr.es o la de localhost con el puerto para desarrollo
   * @return string URL completa
   */
  public static function serverURL()
  {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
      ? "https://" . $_SERVER['HTTP_HOST']
      : "http://" . $_SERVER['HTTP_HOST'];
  }
}
