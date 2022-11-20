<?php

class Userdata
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;

  /**
   * Campos del apartado de subida de nuevos productos al servidor
   */
  private const INPUTS_ARTICLE = [
    ["id" => "name", "label" => " Nombre:", "type" => "text", "component" => "input"],
    ["id" => "description", "label" => " Descripción:", "type" => "text", "component" => "input"],
    [
      "id" => "upfile",
      "label" => "Escoge una imagen JPG o PNG para el artículo (Tamaño máximo 200Kb):",
      "options" => "image/png, image/jpeg", "component" => "file"
    ],
  ];

  /**
   * Campos comunes de los registros Cliente y Vendedor y específicos de cada uno.
   * Se utilizarán para la edición de los campos de entrada en la página correspondiente
   */
  private const INPUTS_USERDATA = [
    "buyer" => [
      ["id" => "name", "label" => " Nombre:", "type" => "text", "component" => "input"],
      ["id" => "surname", "label" => " Apellidos:", "type" => "text", "component" => "input"],
      ["id" => "dni", "label" => " DNI:", "type" => "text", "component" => "input"]
    ],
    "seller" => [
      ["id" => "name", "label" => " Nombre o razón social:", "type" => "text", "component" => "input"],
      ["id" => "cif", "label" => " CIF:", "type" => "text", "component" => "input"]
    ],
    "common" => [
      ["id" => "phone", "label" => " Teléfono:", "type" => "tel", "component" => "input"],
      ["id" => "email", "label" => " Correo electrónico:", "type" => "email", "component" => "input"],
      ["id" => "address", "label" => " Dirección:", "type" => "text", "component" => "input"],
      ["id" => "city", "label" => " Localidad:", "type" => "text", "component" => "input"],
      ["id" => "province", "label" => " Provincia:", "type" => "text", "component" => "input"],
      ["id" => "password", "label" => " Contraseña:", "type" => "password", "component" => "input"]
    ]
  ];


  /**
   * Crea el código de perfil de Cliente o Vendedor
   *
   * @param string $user El perfil a crear y los formularios según el tipo de usuario. Opciones disponibles:
   *                "buyer": Crea el perfil con los campos necesarios para la cuenta de Cliente
   *                "seller": Crea el perfil con los campos necesarios para la cuenta de empresa Vendedor
   * @return string Código HTML con el perfil para ser insertado en el documento
   */
  public  function __construct(string $urlServer, string $user, string $username)
  {
    $this->code = '<section class="section-userdata">';
    $this->code .= $this->getGreeting($username);
    if ($user === 'seller') {
      $this->code .= $this->getUpArticle($urlServer);
    }
    $this->code .= $this->getUserdata($urlServer, $user);
    $this->code .= '</section>';
  }


  /**
   * Undocumented function
   *
   * @param string $username
   * @return string
   */
  public function getGreeting(string $username): string
  {
    $code = '<h4 class="greeting">Bienvenido ' . $username . '</h4>';

    return $code;
  }


  /**
   * Formulario con los campos necesarios para subir un nuevo artúculo al servidor
   *
   * @param string $urlServer Ruta del archivo del servidor al que se envía el formulario
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getUpArticle(string $urlServer): string
  {
    $form = new Form(
      [
        'name' => 'addArticle',
        'legend' => 'Subir producto',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      self::INPUTS_ARTICLE,
      [
        'text' => 'Publicar',
        'icon' => 'chevron_right'
      ],
      ''
    );

    return $form->getCode();
  }


  /**
   * Formulario con los datos del usuario, para la visualización o edición
   *
   * @param string $urlServer Ruta del archivo del servidor al que se envía el formulario
   * @param string $user Indica el tipo de formulario a cargar (Cliente o Vendedor)
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getUserdata(string $urlServer, string $user): string
  {
    $input = self::INPUTS_USERDATA['common'];
    if ($user === 'seller') {
      $input = array_merge(self::INPUTS_USERDATA['seller'], $input);
    } elseif ($user === 'buyer') {
      $input = array_merge(self::INPUTS_USERDATA['buyer'], $input);
    }

    $form = new Form(
      [
        'name' => 'userdata',
        'legend' => 'Datos de usuario',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      $input,
      [
        'text' => 'Enviar',
        'icon' => 'chevron_right'
      ],
      ''
    );

    return $form->getCode();
  }


  /**
   * Devuelve el contenido HTML del la página perfil
   *
   * @return string Código HTML de la página Contacto para ser insertado
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
