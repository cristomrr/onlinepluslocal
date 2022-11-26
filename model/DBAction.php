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
    $result = $this->db->query('SELECT articles.id as idarticle, name, img, description, price, 
                                       users.id as iduser, username, phone, email, address, city, province
                                       FROM articles INNER JOIN users ON articles.idusers = users.id');

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
    $sql = 'SELECT articles.id as idarticle, name, img, description, price, users.id as iduser, username, phone, email, address, city, province, favorites.idusers as favorite 
    FROM favorites 
    INNER JOIN users ON favorites.idusers = users.id 
    INNER JOIN articles ON favorites.idusers = articles.id 
    WHERE favorites.idusers=' . intval($idUser);

    // echo $sql;
    // exit();

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }





  public function checkUserEmail($email): bool
  {
    $result = $this->db->query('SELECT COUNT(*) FROM users where email=' . $email);
    $resp = $result->fetch_array(MYSQLI_ASSOC);

    return $resp;
  }

  public function checkUserLogin(string $email, string $passw)
  {
    $result = $this->db->query("SELECT id FROM users where email='$email' AND password='$passw'");
    $resp = $result->fetch_array(MYSQLI_ASSOC);

    return $resp;
  }

  public function setUser(array $user)
  {
    $result = $this->db->query("INSERT INTO users (id, name, document, phone, email, address, city, province, password)
    VALUES ( null, $user[name], $user[document],  $user[phone], $user[email], $user[address], $user[city], $user[province], $user[password])");

    return $result->fetch_assoc(MYSQLI_NUM);
  }

  public function getUser(int $id)
  {
    $result = $this->db->query("SELECT id, name, document, phone, email, address, city, province FROM users WHERE id=$id");
    $resp = $result->fetch_assoc(MYSQLI_ASSOC);

    return $resp;
  }
}
