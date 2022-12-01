<?php

class DBAction
{
  private mixed $db;
  public function __construct()
  {
    $this->db = DBConnect::getMysqlConnect();
  }


  /**
   * Obtiene todos los artículos o todos los que cumplan la condición del parámetro
   *
   * @param string $extra Código SQL extra encargado de filtrar resultados, como 'Limit 1,5'
   * @return array La colección de resultados
   */
  public function getAllArticles(string $extra = ''): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, 
    users.id as iduser, username, phone, email, address, city, province
    FROM articles INNER JOIN users ON articles.idusers = users.id " . $extra;

    $result = $this->db->query($sql);
    $allArticles = $result->fetch_all(MYSQLI_ASSOC);
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
    $allArticles = $result->fetch_all(MYSQLI_ASSOC);
    $userFavorites = $this->getUserIDFavorites(intval($_SESSION['user']));
    foreach ($allArticles as $k => $v) {
      $v['like'] = (in_array($v['idarticle'], $userFavorites));
      $allArticles[$k] = $v;
    }
    return $allArticles;
  }


  /**
   * Devuelve el id del último artículo ingresado en la base de datos
   *
   * @return integer Número de id del último artículo ó 0
   */
  public function getLastIDArticle(): int
  {
    $sql = "SELECT id FROM articles ORDER BY id DESC LIMIT 1";
    $result = $this->db->query($sql);
    $resp = $result->fetch_row();

    return $resp ? $resp[0] : 0;
  }


  /**
   * Almacena un nuevo artículo en la base de datos
   *
   * @param array $v Objeto con las propiedades del artículo
   * @return bool TRUE|FALSE dependiendo de si se completo la acción
   */
  public function setArticle(array $v): bool
  {
    $sql = "INSERT INTO articles(id, name, img, description, price, idusers)
            VALUES($v[id], '$v[name]', '$v[img]', '$v[description]', '$v[price]', $v[iduser])";

    return $this->db->query($sql);
  }


  /**
   * Undocumented function
   *
   * @param int $idUser id del usuario del que se quiere obtener los favoritos
   * @return array Colección con los datos de los favoritos del usuario
   */
  public function getUserFavorites(int $idUser): array
  {
    $sql = "SELECT articles.id as idarticle, name, img, description, price, users.id as iduser, username, phone, email, address, city, province 
    FROM favorites 
    INNER JOIN users ON favorites.idusers = users.id 
    INNER JOIN articles ON articles.id = favorites.idarticles 
    WHERE favorites.idusers=" . $idUser;

    $result = $this->db->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
  }


  /**
   * Obtiene los id de los artículos favoritos del usuario
   *
   * @param int $idUser id del usuario
   * @return array Colección de id de favoritos
   */
  public function getUserIDFavorites(int $idUser): array
  {
    $sql = "SELECT idarticles as idarticle FROM favorites WHERE idusers=$idUser";
    $result = $this->db->query($sql);
    $userFavorites = [];
    while ($row = $result->fetch_assoc()) {
      $userFavorites[] = $row['idarticle'];
    }

    return $userFavorites;
  }


  /**
   * Almacena un nuevo favorito para el usuario con el id pasado por parámetro
   *
   * @param integer $iduser id del usuario al que se le agrega el favorito
   * @param integer $idarticle id del artículo que se pone como favorito
   * @return bool TRUE|FALSE si se completo la consulta
   */
  public function setUserFavorites(int $iduser, int $idarticle): bool
  {
    $sql = "INSERT INTO favorites(id, idusers, idarticles)
            VALUES(null, $iduser, $idarticle)";

    return $this->db->query($sql);
  }


  /**
   * Elimina un artículo favorito a un usuario
   *
   * @param integer $iduser id del usuario al que eliminar el favorito
   * @param integer $idarticle id del artículo a eliminar 
   * @return bool TRUE|FALSE si se completo la consulta
   */
  public function deleteUserFavorites(int $iduser, int $idarticle): bool
  {
    $sql = "DELETE FROM favorites WHERE idusers=$iduser AND idarticles=$idarticle";

    return $this->db->query($sql);
  }


  /**
   * Comprueba si existe ya el email de un usuario
   *
   * @param string $email email del usuario que se quiere comprobar si existe
   * @return bool TRUE|FALSE si se existe o no
   */
  public function checkUserEmailExist(string $email): bool
  {
    $sql = "SELECT COUNT(*) as `mum-users` FROM users where email='$email'";
    $result = $this->db->query($sql);
    $resp = $result->fetch_row();

    return !($resp[0] === '0');
  }


  /**
   * Comprueba los datos del login con los de la base de datos, a ver si las credenciales son correctas
   *
   * @param string $email email del usuario que inicia sesión
   * @param string $passw password del ususario sin encriptar
   * @return mixed
   */
  public function checkUserLogin(string $email, string $passw): mixed
  {
    $password_hash = $this->getPasswordHash($passw);
    $sql = "SELECT id FROM users where email='$email' AND password='$password_hash'";
    $result = $this->db->query($sql);
    return $result->fetch_array(MYSQLI_ASSOC);
  }


  /**
   * almacena un nuevo usuario en la base de datos
   *
   * @param array $v Objeto con los datos del usuario
   * @return bool TRUE|FALSE si se existe o no
   */
  public function setUser(array $v): bool
  {
    $password = $this->getPasswordHash($v['password']);

    $sql = "INSERT INTO 
    users (id, username, document, type, phone, email, address, city, province, password)
    VALUES ( null, '$v[name]', '$v[document]', '$v[type]', '$v[phone]', '$v[email]', '$v[address]', '$v[city]', '$v[province]', '$password')";

    return $this->db->query($sql);
  }


  /**
   * Obtiene los datos de un usuario
   *
   * @param mixed $id id del usuario a obtener
   * @return array datos del usuario obtenido
   */
  public function getUser(mixed $id): array
  {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $this->db->query($sql);
    return $result->fetch_assoc();
  }


  /**
   * Actualiza los datos de un usuario
   *
   * @param array $v datos del usuario en un array asociativo
   * @return bool TRUE|FALSE si se completo la consulta
   */
  public function updateUser(array $v): bool
  {
    $sql = "UPDATE users SET username='$v[name]', document='$v[document]', phone='$v[phone]',
             email='$v[email]', address='$v[address]', city='$v[city]', province='$v[province]'
             WHERE id=$v[id]";

    return $this->db->query($sql);
  }


  /**
   * Encripta el password para que se pueda almacenar en la base de datos de forma segura
   *
   * @param string $password contraseña a encriptar
   * @return string contraseña ya encriptada
   */
  public function getPasswordHash(string $password): string
  {
    return hash(
      'sha256',
      ENV::SALT_PASSWD . hash('sha256', $password . ENV::SALT_PASSWD)
    );
  }
}
