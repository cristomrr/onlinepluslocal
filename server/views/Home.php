<?php

/**
 * Contiene el código vista de la página de inicio y sus subcomponentes.
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Home extends ViewComponent
{

  /**
   * Colección de arrays de los bloques de información de la página principal
   * @var array 
   */
  private array $infoblocks = [
    [
      'img' => "server/assets/img/home-online.png",
      'alt' => "Personas buscando en internet",
      'text' => "La forma de comprar ha cambiado, muchos consumidores prefieren la compra online a la física por algunos beneficios que les aporta esas grandes empresas online, como compra más rápida al no desplazarse o más variedad y elección de lo buscado"
    ],
    [
      'img' => "server/assets/img/home-shops.jpg",
      'alt' => "Negocios cerrados",
      'text' => "Este proyecto fue creado para ayudar a las pequeñas empresas, las cuales estaban cerrando debido a la falta de visibilidad al estar a la sombra de las grandes que han abarcado casi todo el mercado de la era digital"
    ],
    [
      'img' => "server/assets/img/home-buy.png",
      'alt' => "Mujer comprando por el teléfono inteligente",
      'text' => "Lo que queremos lograr, es unir a todas esos pequeños negocios en un solo sitio, donde puedan así ofrecer al consumidor esas ventajas de la venta online en una plataforma, ofreciendo una mayor oferta de productos y precios competentes, junto a la posibilidad de recogerlo al lado de casa y pagarlo a la hora de recogerlo"
    ],
    [

      'img' => "server/assets/img/home-team.png",
      'alt' => "Personas levantando el logo de Online plus local",
      'text' => "¿Nuestra recompensa?... ayudar al consumidor,  para obtener una mayor oferta, mayor variedad de productos y todo a los mejores precios al existir mayor competencia. Y facilitar al comerciante esa visibilidad y posibilidad de llegar a una mayor cantidad de consumidores"
    ]
  ];

  /**
   * Mensaje llamativo que saldrá antes del pie de página
   */
  private const LAST_MSG = 'Los tiempos están cambiando.. y nuestra forma de comprar también';


  /**
   * Prepara el contenido de la página de inicio del sitio
   */
  public function __construct()
  {
    $imgGirl = new ImgGirl('¡Bienvenid@ a OnlinePlusLocal!');

    // Sección con la imagen de la chica como bienvenida
    $code = '<section class="home-girl">' . $imgGirl->getCode() . '</section>';
    // Sección de imágenes con información del programa a lo largo del documento
    $code .= '<section class="home-info">' . $this->getInfoBlocks() . '</section>';
    // Sección final con un mensaje llamativo
    $code .= '<p class="home-final-text">' . self::LAST_MSG . '</p>';

    parent::__construct($code);
  }


  /**
   * Devuelve todos los bloques de información que irán en el contenido de la página Home con una imagen e información
   *
   * @return string
   */
  private function getInfoBlocks(): string
  {
    $infoHome = '';

    $isReverse = false;
    foreach ($this->infoblocks as $info) {
      $addClass = $isReverse ? '' : 'reverse';
      $infoHome .= $this->getHomeInfo($info['img'], $info['text'], $info['alt'], $addClass);
      $isReverse = !$isReverse;
    }

    return $infoHome;
  }


  /**
   * Bloques de información/imagen para agregar en la página de inicio como descripción del programa
   *
   * @param string $img Ruta a la imagen del bloque informativo
   * @param string $text Texto informativo a dar al usuario en ese bloque
   * @param string $alt Texto alternativo de la imagen
   * @param string $order Orden de visualización en  o . Disponible:
   *                "reverse": (imagen/texto)
   *                "": (texto/imagen)
   * @return string Código HTML con el bloque informativo listo para ser insertado en el documento
   */
  private function getHomeInfo(string $img, string $text, string $alt, string $order): string
  {
    return '<div class="info-box ' . $order . '">
                        <p class="info">' . $text . '</p>
                        <picture>
                            <img src=' . $img . ' alt=' . $alt . ' />
                        </picture>
                    </div>';
  }
}
