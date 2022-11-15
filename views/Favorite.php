<?php

/**
 * Clase que crea la vista del buscador de artículos. Contiene:
 *  - Formulario de búsqueda
 *  - Resultados de artículos
 */
class Favorite
{
  private string $code;

  /**
   * Construcción de la vista Búsqueda
   */
  public function __construct()
  {
    $imgGirl = new ImgGirl('¡Ohh! que cosas te gustan');

    //TODO: Código de artículos para pruebas, eliminar cuando se trabaje con la DB (línea 40-46)

    $this->code = '<section class="search">
              <div class="girl">
                ' . $imgGirl->getCode() . '
              </div>
            </section>
            
            <section class="result-search">
              <h4 class="global-title-plane">4 artículos favoritos:</h4>
              <div class="articles">

              ' . Article::getPreview('1', './assets/img-product/short1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('2', './assets/img-product/hair1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('3', './assets/img-product/shirt1.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('4', './assets/img-product/shirt2.png', 'imagen producto', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '
              
              </div>
            </section>';
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
