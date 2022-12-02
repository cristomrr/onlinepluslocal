<?php

/**
 * Clase encargada de almacenar las variables con información sensible, para no ser envíada al repositorio
 */
class ENV
{
  // EMAIL
  public const EMAIL_ACCOUNT = "onlinepluslocal@cmrr.es";
  public const EMAIL_PASSWORD = "";

  // DATABASE MARIADB
  public const DATABASE_NAME = 'onlinepluslocal';
  public const DATABASE_HOST = '';

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
    'login' => 'iniciar-sesion',
    'signup-seller' => 'registro-empresa',
    'signup-buyer' => 'registro-cliente',
    'contact' => 'contacto',
    'search' => '/buscador',
    'favorites' => 'favoritos',
    'userdata' => 'perfil',
  ];

  /**
   * Genera la URL del servidor con el protocolo. Pudiendo ser: 
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
