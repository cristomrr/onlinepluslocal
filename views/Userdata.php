<?php

/**
 * Clase encargada de la vista del perfil de usuario
 */
class Userdata extends ViewComponent
{
  /**
   * Campos del apartado de subida de nuevos productos al servidor
   */
  private const INPUTS_ARTICLE = [
    ["id" => "name", "label" => " Nombre:", "type" => "text", "component" => "input"],
    ["id" => "price", "label" => " Precio:", "type" => "number", "component" => "input"],
    ["id" => "description", "label" => " Descripción:", "options" => ["cols" => "20", "rows" => "5"], "component" => "textarea"],
    [
      "id" => "upfile",
      "label" => "Imagen JPG o PNG del artículo (Tamaño máximo 200Kb):",
      "options" => "image/png, image/jpeg", "component" => "file"
    ],
  ];


  /**
   * Campos comunes de los registros Cliente y Vendedor y específicos de cada uno.
   * Se utilizarán para la edición de los campos de entrada en la página correspondiente
   */
  private const INPUTS_USERDATA = [
    "buyer" => [
      ["id" => "name", "label" => " Nombre y apellidos:", "type" => "text", "component" => "input-value", "value" => ''],
      ["id" => "document", "label" => " DNI:", "type" => "text", "component" => "input-value", "value" => '']
    ],
    "seller" => [
      ["id" => "name", "label" => " Nombre o razón social:", "type" => "text", "component" => "input-value", "value" => ''],
      ["id" => "document", "label" => " CIF:", "type" => "text", "component" => "input-value", "value" => '']
    ],
    "common" => [
      ["id" => "phone", "label" => " Teléfono:", "type" => "tel", "component" => "input-value", "value" => ''],
      ["id" => "email", "label" => " Correo electrónico:", "type" => "email", "component" => "input-value", "value" => ''],
      ["id" => "address", "label" => " Dirección:", "type" => "text", "component" => "input-value", "value" => ''],
      ["id" => "city", "label" => " Localidad:", "type" => "text", "component" => "input-value", "value" => ''],
      ["id" => "province", "label" => " Provincia:", "type" => "text", "component" => "input-value", "value" => '']
    ]
  ];


  /**
   * Crea el código de perfil de Cliente o Vendedor
   *
   * @param array $url Rutas de enlace, como al archivo principal del servidor para formularios
   * @param array $user El perfil a crear y los formularios según el tipo de usuario. Opciones disponibles:
   *                "buyer": Crea el perfil con los campos necesarios para la cuenta de Cliente
   *                "seller": Crea el perfil con los campos necesarios para la cuenta de empresa Vendedor
   *
   */
  public  function __construct(array $url, array $user)
  {
    $code = '<section class="section-userdata">';
    $code .= $this->getGreeting($user['username']);
    if ($user['type'] === 'seller') {
      $code .= $this->getUpArticle($url['server']);
    }
    $code .= $this->getHelpSection();
    $code .= $this->getUserdata($url['server'], $user);
    $code .= '</section>';

    parent::__construct($code);
  }


  /**
   * Código HTML con un saludo
   *
   * @param string $username nombre del usuario que inicio sesión
   * @return string código HTML del componente
   */
  public function getGreeting(string $username): string
  {
    $firstname = explode(' ', $username);
    $code = '<h4 class="greeting">Bienvenido ' . $firstname[0] . '</h4>';

    return $code;
  }


  /**
   * Formulario con los campos necesarios para subir un nuevo artículo al servidor
   *
   * @param string $urlServer Ruta del archivo del servidor al que se envía el formulario
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getUpArticle(string $urlServer): string
  {
    $form = new Form(
      [
        'name' => 'addarticle',
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
   * Código HTML con mensaje y un enlace de ayuda para editar imágenes
   *
   * @return string código HTML del componente
   */
  public function getHelpSection():string
  {
    $code = '<div class=help-img-editor>
               <h4>Si necesitas ayuda para reducir el tamaño o editar la imagen, te ofrecemos la siguiente página:</h4>
               <a href="https://pixlr.com/es/suite/" target="_blank">Editor de imagen</a> 
            </div>';

    return $code;
  }


  /**
   * Formulario con los datos del usuario, para la visualización o edición
   *
   * @param string $urlServer Ruta del archivo del servidor al que se envía el formulario
   * @param array $user colección con los datos del usuario
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getUserdata(string $urlServer, array $user): string
  {
    $input = self::INPUTS_USERDATA['common'];
    if ($user['type'] === 'seller') {
      $input = array_merge(self::INPUTS_USERDATA['seller'], $input);
    } elseif ($user['type'] === 'buyer') {
      $input = array_merge(self::INPUTS_USERDATA['buyer'], $input);
    }

    $input[0]['value'] = $user['username'];
    $input[1]['value'] = $user['document'];
    $input[2]['value'] = $user['phone'];
    $input[3]['value'] = $user['email'];
    $input[4]['value'] = $user['address'];
    $input[5]['value'] = $user['city'];
    $input[6]['value'] = $user['province'];

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
}
