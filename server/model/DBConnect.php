<?php

class DBConnect
{
  /**
   * Crea una conexión con la base de datos Mysql/MariaDB
   *
   * @return mixed la conexión o false si no ha podido conectar
   */
  public static function getMysqlConnect(): mixed
  {
    $mysqli = new mysqli(
      ENV::DATABASE_HOST,
      ENV::DATABASE_USER,
      ENV::DATABASE_PASSWORD,
      ENV::DATABASE_NAME,
      ENV::DATABASE_PORT
    );
    if ($mysqli->connect_errno) {
      return false;
    }
    return $mysqli;
  }
}
