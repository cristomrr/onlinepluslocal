<?php

/**
 * Clase con las vistas de los registros Cliente y Vendedor
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Signup extends ViewComponent
{
  /**
   * Título del formulario según si el registro es de Clientes o Vendedores
   */
  private const TITLE = ["buyer" => "Registro clientes", "seller" => "Registro vendedores"];

  /**
   * Campos comunes de los registros Cliente y Vendedor y específicos de cada uno.
   * Se utilizarán para la creación de los campos de entrada en la página correspondiente
   */
  private const INPUT = [
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
      ["id" => "password", "label" => " Contraseña:", "type" => "password", "component" => "input"],
      ["id" => "password-repeat", "label" => " Repite contraseña:", "type" => "password", "component" => "input"]
    ]
  ];

  /**
   * Texto informativo importante para el usuario, dependiendo del tipo de registro
   */
  private const WARNING = [
    "buyer" => [
      ["Este registro es para usuarios que quieran localizar productos, si eres una empresa que quiere publicar sus
      productos, elige la opción de registro de empresa"],
    ],
    "seller" => [
      ["Este registro es solo para las empresas que quieran publicar sus productos, si eres cliente utiliza la opción de registro de cliente"],
      ["Recuerda que todos los datos son obligatorios, ya que se necesitan para contactar el cliente y el CIF para
      demostrar que es una empresa legal en España"]
    ]
  ];

  /**
   * Crea el código de registro de Cliente o Vendedor
   *
   * @param array $url Rutas de enlace, como al archivo principal del servidor para formularios
   * @param string $user El registro a crear y los componentes informativos. Opciones disponibles:
   *                "buyer": Crea el registro con los campos necesarios para la cuenta de Cliente
   *                "seller": Crea el registro con los campos necesarios para la cuenta de empresa Vendedor
   * @return string Código HTML con el registro para ser insertado en el documento
   */
  public  function __construct(array $url, string $user)
  {
    $inputs = array_merge(self::INPUT[$user], self::INPUT['common']);

    $code = '<section class="section-signup">
                    <div class="form-box">';
    $code .= self::getForm($url['server'], $user, $inputs) .
      '</div>';
    $code .= self::getInfo($user, $url['signup-seller'], $url['signup-buyer']);
    $code .= '</section>';

    parent::__construct($code);
  }


  /**
   * Contiene el formulario de login
   *
   * @param string $formServer Ruta al archivo del servidor al que se le enviará los formularios
   * @param string $user Tipo de usuario del formulario (Cliente o Vendedor)
   * @param array $inputs los campos a ingresar en el formulario
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getForm($urlServer, $user, $inputs): string
  {
    $form = new Form(
      [
        'name' => 'signup-' . $user,
        'legend' => self::TITLE[$user],
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      $inputs,
      [
        'text' => 'Enviar registro',
        'icon' => 'chevron_right'
      ],
      ''
    );

    return $form->getCode();
  }


  /**
   * Crea el código HTML para la sección informativa al usuario y enlace al otro registro de usuario
   *
   * @param string $user Tipo de usuario. Opciones disponibles:
   *                "buyer": para información al Cliente
   *                "seller": para información al Vendedor
   * @param string $urlBuyer Enlace a la página de registro de clientes
   * @param string $urlBuyer Enlace a la página de registro de vendedores
   * @return string Código HTML con la sección informativa lista para ser agregada al documento
   */
  private function getInfo(string $user, string $urlBuyer, string $urlSeller): string
  {
    $optioninfo = match ($user) {
      "buyer" => ['title' => "¿Eres vendedor?...", "label" => "Regístrate aquí como empresa", "href" => "/?page=$urlBuyer"],
      "seller" => ["title" => "¿Eres cliente?...", "label" => "Regístrate aquí como cliente", "href" => "/?page=$urlSeller"],
    };

    $info = '<div class="info-box">
                <p class="info">
                  ' . $optioninfo['title'] . '
                  <a href="' . $optioninfo['href'] . '">' . $optioninfo['label'] . '</a>
                </p>';

    foreach (self::WARNING[$user] as $value) {
      $info .= '<p class="warning">' . $value[0] . '</p>';
    }

    $info .= '</div>';

    return $info;
  }
}
