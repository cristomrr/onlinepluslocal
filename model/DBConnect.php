<?php

class DBConnect
{
  protected mysqli $mysqli;

  /**
   * Crea una conexión con la base de datos mysql
   *
   * @return mixed la conexión o false si no ha podido conectar
   */
  public static function getMysqlConnect(): mixed
  {
    require_once './model/DB_MYSQL.php';

    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE, PORT);
    if ($mysqli->connect_errno) {
      return false;
    }
    return $mysqli;
  }
}
