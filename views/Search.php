<?php

/**
 * Clase que crea la vista del buscador de artículos. Contiene:
 *  - Formulario de búsqueda
 *  - Resultados de artículos
 */
class Search
{
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
   * 
   */
  public function __construct($urlServer)
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
            </section>
            
            <section class="result-search">
              <h4 class="global-title-plane">Resultados:</h4>
              <div class="articles">

              ' . Article::getPreview('1', './assets/img-product/short1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', false) . '

              ' . Article::getPreview('2', './assets/img-product/hair1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', false) . '

              ' . Article::getPreview('3', './assets/img-product/shirt1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', false) . '

              ' . Article::getPreview('4', './assets/img-product/shirt2.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', false) . '
              
              </div>
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
