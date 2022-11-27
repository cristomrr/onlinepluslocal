<?php
require_once './model/DBConnect.php';

class DBAction
{
  private $db;
  public function __construct()
  {
    $this->db = DBConnect::getMysqlConnect();
  }

  /**
   * Obtiene todos los artículos
   *
   * @return array
   */
  public function getAllArticles(): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, 
    users.id as iduser, username, phone, email, address, city, province
    FROM articles INNER JOIN users ON articles.idusers = users.id";

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }

  /**
   * Obtiene el artículo que contenga el valor en el campo especificado por parámetro
   *
   * @param string $filter parte de la sentencia sql que filtra artículos (WHERE, LIKE, ..)
   * @return array Se devuelve el valor en un array asociativo tipo ['id'=>valor]
   */
  public function getArticle(string $filter): array
  {
    $sql = 'SELECT articles.id as idarticle, name, img, description, price, 
    users.id as iduser, username, phone, email, address, city, province
    FROM articles 
    INNER JOIN users ON articles.idusers = users.id ' . $filter;

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }


  public function getUserFavorites($idUser): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, users.id as iduser, username, phone, email, address, city, province, favorites.idusers as favorite 
    FROM favorites 
    INNER JOIN users ON favorites.idusers = users.id 
    INNER JOIN articles ON favorites.idusers = articles.id 
    WHERE favorites.idusers=" . intval($idUser);

    // echo $sql;
    // exit();

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }


  public function checkUserEmailExist($email): bool
  {
    $sql = "SELECT COUNT(*) as `mum-users` FROM users where email='$email'";
    $result = $this->db->query($sql);
    $resp = $result->fetch_row();

    return !($resp[0] === '0');
  }

  public function checkUserLogin(string $email, string $passw)
  {
    $sql = "SELECT id FROM users where email='$email' AND password='$passw'";
    $result = $this->db->query($sql);
    $resp = $result->fetch_array(MYSQLI_ASSOC);

    return $resp;
  }

  public function setUser(array $v)
  {
    $sql = "INSERT INTO 
    users (id, username, document, type, phone, email, address, city, province, password)
    VALUES ( null, '$v[name]', '$v[document]', '$v[type]', '$v[phone]', '$v[email]', '$v[address]', '$v[city]', '$v[province]', '$v[password]')";

    return $this->db->query($sql);
  }

  public function getUser(mixed $id)
  {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $this->db->query($sql);
    $resp = $result->fetch_assoc();

    return $resp;
  }
}
