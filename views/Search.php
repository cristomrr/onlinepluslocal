<?php

/**
 * Clase que crea la vista del buscador de artículos. Contiene:
 *  - Formulario de búsqueda
 *  - Resultados de artículos
 */
class Search
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;

  private const INPUTS_SEARCH = [
    ["id" => "name", "label" => " Producto:", "type" => "text", "component" => "input"],
    ["id" => "province", "label" => " Provincia:", "type" => "text", "component" => "input"],
    ["id" => "city", "label" => " Localidad:", "type" => "text", "component" => "input"]
  ];


  /**
   * Construcción de la vista Búsqueda
   * 
   * @param string $urlServer Ruta al archivo del servidor al que se le enviará los formularios
   * @param array $articles Colección con los favoritos del usuario   * 
   */
  public function __construct(string $urlServer, array $articles = [])
  {
    $imgGirl = new ImgGirl('¡Nos vamos de compras!');

    //TODO: Código de artículos para pruebas, eliminar cuando se trabaje con la DB (línea 40-46)

    $this->code = '<section class="search">
              <div class="girl">
                ' . $imgGirl->getCode() . '
              </div>
              <div class="form-search">
                ' . self::getForm($urlServer) . '
              </div>
            </section>';

    $this->code .= '<section class="result-search">
              <h4 class="global-title-plane">Resultados:</h4>
              <div class="articles">';

    foreach ($articles as $k => $v) {
      $this->code .= Article::getPreview(
        $v['id'],
        $v['img'],
        $v['name'],
        $v['shop'],
        $v['description'],
        $v['price'],
        false
      );
    }


    $this->code .= '</div>
            </section>';
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
        'method' => 'GET',
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


  /**
   * Devuelve el contenido HTML del la página contacto
   *
   * @return string Código HTML de la página Contacto para ser insertado
   */
  public function getCode(): string
  {
    return $this->code;
  }
}


/*!SECTION

' . Article::getPreview('1', './assets/test/img-product/2/short1.png','pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('2', './assets/test/img-product/2/hair1.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('3', './assets/test/img-product/1/shirt1.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('4', './assets/test/img-product/1/shirt2.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '


*/