<?php

class DBAction
{
  private $db;
  private const SALT_PASSWD = 'CMRR';
  public function __construct()
  {
    $this->db = DBConnect::getMysqlConnect();
  }

  /**
   * Obtiene todos los artículos
   *
   * @return array
   */
  public function getAllArticles($extra = ''): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, 
    users.id as iduser, username, phone, email, address, city, province
    FROM articles INNER JOIN users ON articles.idusers = users.id " . $extra;

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }

  public function getAllArticlesMarkFavorites()
  {
    $allArticles = $this->getAllArticles();
    $userFavorites = $this->getUserIDFavorites(intval($_SESSION['user']));
    foreach ($allArticles as $k => $v) {
      $v['like'] = (in_array($v['idarticle'], $userFavorites));
      $allArticles[$k] = $v;
    }
    return $allArticles;
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


  public function getLastIDArticle(): int
  {
    $sql = "SELECT id FROM articles ORDER BY id DESC LIMIT 1";
    $result = $this->db->query($sql);
    $resp = $result->fetch_row();

    return $resp ? $resp[0] : 0;
  }


  public function setArticle(array $v)
  {
    $sql = "INSERT INTO articles(id, name, img, description, price, idusers)
            VALUES($v[id], '$v[name]', '$v[img]', '$v[description]', '$v[price]', $v[iduser])";

    return $this->db->query($sql);
  }


  public function getUserFavorites($idUser): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, users.id as iduser, username, phone, email, address, city, province 
    FROM favorites 
    INNER JOIN users ON favorites.idusers = users.id 
    INNER JOIN articles ON articles.id = favorites.idarticles 
    WHERE favorites.idusers=" . intval($idUser);

    $result = $this->db->query($sql);
    $resp = $result->fetch_all(MYSQLI_ASSOC);

    return $resp;
  }

  public function getUserIDFavorites($idUser): array
  {
    $sql = "SELECT idarticles as idarticle FROM favorites WHERE idusers=$idUser";
    $result = $this->db->query($sql);
    $userFavorites = [];
    while ($row = $result->fetch_assoc()) {
      $userFavorites[] = $row['idarticle'];
    }

    return $userFavorites;
  }


  public function setUserFavorites(int $iduser, int $idarticle)
  {
    $sql = "INSERT INTO favorites(id, idusers, idarticles)
            VALUES(null, $iduser, $idarticle)";

    return $this->db->query($sql);
  }


  public function deleteUserFavorites(int $iduser, int $idarticle)
  {
    $sql = "DELETE FROM favorites WHERE idusers=$iduser AND idarticles=$idarticle";

    return $this->db->query($sql);
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
    $password_hash = $this->getPasswordHash($passw);
    $sql = "SELECT id FROM users where email='$email' AND password='$password_hash'";
    $result = $this->db->query($sql);
    $resp = $result->fetch_array(MYSQLI_ASSOC);

    return $resp;
  }

  public function setUser(array $v)
  {
    $password = $this->getPasswordHash($v['password']);

    $sql = "INSERT INTO 
    users (id, username, document, type, phone, email, address, city, province, password)
    VALUES ( null, '$v[name]', '$v[document]', '$v[type]', '$v[phone]', '$v[email]', '$v[address]', '$v[city]', '$v[province]', '$password')";

    return $this->db->query($sql);
  }

  public function getUser(mixed $id)
  {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $this->db->query($sql);
    $resp = $result->fetch_assoc();

    return $resp;
  }


  public function getPasswordHash(string $password)
  {
    $password_hash = hash(
      'sha256',
      self::SALT_PASSWD . hash('sha256', $password . self::SALT_PASSWD)
    );

    return $password_hash;
  }

  public function updateUser($v)
  {
    $sql = "UPDATE users SET username='$v[name]', document='$v[document]', phone='$v[phone]',
             email='$v[email]', address='$v[address]', city='$v[city]', province='$v[province]'
             WHERE id=$v[id]";

    return $this->db->query($sql);
  }





  // TODO: Eliminar, se agrego para encriptar el password de usuarios de la base de datos
  public function setPasswdDB($passw, $id)
  {
    $sql = "UPDATE users SET password='$passw' WHERE id=$id";
    $result = $this->db->query($sql);
  }
}
