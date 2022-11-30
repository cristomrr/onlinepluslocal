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
}
