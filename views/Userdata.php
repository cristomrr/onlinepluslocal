<?php

class Userdata
{
  private string $code;

  /**
   * 
   */
  private const INPUT_ARTICLE = [
    ["id" => "name", "label" => " Nombre:", "type" => "text", "component" => "input"],
    ["id" => "description", "label" => " Descripción:", "type" => "text", "component" => "input"]
  ];

  /**
   * Campos comunes de los registros Cliente y Vendedor y específicos de cada uno.
   * Se utilizarán para la edición de los campos de entrada en la página correspondiente
   */
  private const INPUT_USERDATA = [
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

  public function getGreeting($username): string
  {
    $code = '<h4 class="greeting">Bienvenido ' . $username . '</h4>';

    return $code;
  }

  private function getUpArticle($urlServer): string
  {
    $form = new Form(
      [
        'name' => 'addArticle',
        'legend' => 'Subir producto',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      self::INPUT_ARTICLE,
      [
        'text' => 'Publicar',
        'icon' => 'chevron_right'
      ],
      ''
    );

    return $form->getCode();
  }

  private function getUserdata($urlServer, $user): string
  {
    $input = self::INPUT_USERDATA['common'];
    if ($user === 'seller') {
      $input = array_merge(self::INPUT_USERDATA['seller'], $input);
    } elseif ($user === 'buyer') {
      $input = array_merge(self::INPUT_USERDATA['buyer'], $input);
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
