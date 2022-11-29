<?php

/**
 * Clase con la vista de la página Contacto y sus componentes
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Contact extends ViewComponent
{
  private const PHONE = '922999999';
  private const MAIL = 'info@onlinepluslocal.com';
  private  const ADDRESS = 'Calle los Angeles 25, 38690 Puerto Santiago';
  public const LOCATION_MAP = 'https://www.google.com/maps/place/C.+los+%C3%81ngeles,+25,+38683+Santiago+del+Teide,+Santa+Cruz+de+Tenerife,+Espa%C3%B1a/@28.237661,-16.841642,15z/data=!4m5!3m4!1s0xc6a8c40a126a2b5:0x7abaafebf3cd8236!8m2!3d28.2376614!4d-16.841642?hl=es';
  private const INPUTS_SEARCH = [
    ["id" => "subject", "label" => " Asunto:", "type" => "text", "component" => "input"],
    ["id" => "email", "label" => " Correo electrónico:", "type" => "email", "component" => "input"],
    ["id" => "msg", "label" => " Mensaje:", "options" => ["cols" => "30", "rows" => "10"], "component" => "textarea"]
  ];

  
  /**
   * Constructor del contenido del la página Contacto
   *
   * @param array $url Rutas de enlace, como al archivo principal del servidor para formularios
   */
  public function __construct(array $url)
  {
    $code = '<section class="contact-section">
                      <div class="info-section">
                        <div class="info">
                          <h2 class="global-title">¿Dónde estamos?</h2>
                          <div class="links">
                            ' . $this->getLink(self::LOCATION_MAP, "location_on", self::ADDRESS) . '
                            ' . $this->getLink("mailto:onlinepluslocal@cmrr.es", "mail", self::MAIL) . '
                            ' . $this->getLink("tel:+34" . self::PHONE, "phone", self::PHONE) . '
                          </div>
                        </div>
                        ' . $this->getMap() . '
                      </div>
                      <div class="form-box">
                        <div class="form-content">
                          ' . $this->getForm($url['server']) . '
                        </div>
                      </div>
                    </section>';

    parent::__construct($code);
  }


  /**
   * Crea enlaces con icono según los parámetros de entrada. Utilizado para los datos de contacto.
   *
   * @param string $href URI para el enlace al archivo, teléfono, localización Google Maps o email
   * @param string $text Nombre del icono de Google Icons a usar
   * @param string $title Texto que acompaña al icono (teléfono, dirección, email,..)
   * @return string Código HTML con el enlace a insertar en el documento
   */
  private function getLink(string $href, string $text, string $title): string
  {

    return '<a class="box-button" href=' . $href . ' target=_self>
              <p>
              <span class="material-symbols-outlined icon">' . $text . '</span>
              ' . $title . '
              </p>
            </a>';
  }

  /**
   * Contiene el iframe con la ubicación de Onlinepluslocal en Google Maps
   *
   * @return string Código HTML con el iframe de ubicación de Google Maps
   */
  private function getMap(): string
  {
    return '<iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3515.000448946604!2d-16.846126669684228!3d28.23766605287179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xc6a8c40a126a2b5%3A0x7abaafebf3cd8236!2sC.%20los%20%C3%81ngeles%2C%2025%2C%2038683%20Santiago%20del%20Teide%2C%20Santa%20Cruz%20de%20Tenerife%2C%20Espa%C3%B1a!5e0!3m2!1ses!2sus!4v1666841890112!5m2!1ses!2sus"
                        style="border:1px solid grey;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localización OnlinePlusLocal"
                        >
            </iframe>';
  }

  /**
   * Contiene el formulario de contacto
   *
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getForm($urlServer): string
  {
    $form = new Form(
      [
        'name' => 'contact',
        'legend' => 'Contacto',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      self::INPUTS_SEARCH,
      [
        'text' => 'Enviar',
        'icon' => 'outgoing_mail'
      ],
      ''
    );

    return $form->getCode();
  }
}
