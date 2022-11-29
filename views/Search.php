<?php

/**
 * Clase que crea la vista del buscador de artículos. 
 */
class Search extends ViewComponent
{
  private const INPUTS_SEARCH = [
    ["id" => "name", "label" => " Producto:", "type" => "text", "component" => "input"],
    ["id" => "province", "label" => " Provincia:", "type" => "text", "component" => "input"],
    ["id" => "city", "label" => " Localidad:", "type" => "text", "component" => "input"]
  ];


  /**
   * Construcción de la vista Búsqueda
   * 
   * @param array $urlServer Ruta al archivo del servidor al que se le enviará los formularios
   * @param array $articles Colección con los favoritos del usuario   * 
   */
  public function __construct(array $url, array $articles = [])
  {
    $imgGirl = new ImgGirl('¡Nos vamos de compras!');

    $code = '<section class="search">
              <div class="girl">
                ' . $imgGirl->getCode() . '
              </div>
              <div class="form-search">
                ' . self::getForm($url['server']) . '
              </div>
            </section>';

    $code .= '<section class="result-search">
              <h4 class="global-title-plane">Resultados: ' . count($articles) . '</h4>
              <div class="articles">';

    if (count($articles) !== 0) {
      foreach ($articles as $k => $v) {
        $code .= Article::getPreview($v, $v['like']);
      }
    } else {
      $code .= '<p class=zero-articles>No existen artículos</p>';
    }

    $code .= '<div class=box-more-articles><button>Cargar más ...</button></div>';
    $code .= '</div></section>';

    parent::__construct($code);
  }


  /**
   * Crea el formulario para búsqueda de artículos
   *
   * @param string $urlServer Ruta al archivo del servidor al que se le enviará los formularios
   * @return string Código HTML del formulario para ser insertado al documento
   */
  private function getForm(string $urlServer): string
  {

    $form = new Form(
      [
        'name' => 'search',
        'legend' => 'Buscador',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => false
      ],
      self::INPUTS_SEARCH,
      [
        'text' => 'Iniciar búsqueda',
        'icon' => ''
      ],
      ''
    );

    return $form->getCode();
  }
}
