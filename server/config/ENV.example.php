<?php

/**
 * Clase encargada de almacenar las variables con información sensible, para no ser envíada al repositorio
 */
class ENV
{
  // EMAIL
  public const EMAIL_ACCOUNT = "";
  public const EMAIL_PASSWORD = "";

  // DATABASE MARIADB
  public const DATABASE_NAME = '';
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
   * URL a cada página del sitio web
   */
  public const URL = [
    'server' => '',
    'signup-seller' => '',
    'signup-buyer' => '',
    'contact' => '',
    'privacy' => '',
  ];

  /**
   * Sitios que serán accesibles si se ha iniciado sesión
   */
  public const PAGES_NEED_SESSION = ['', '', '', ''];
}
