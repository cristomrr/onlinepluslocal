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
   * 
   * @param array $articles Colección con los favoritos del usuario
   */
  public function __construct(array $articles = [])
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

              ' . Article::getPreview('1', './assets/test/img-product/2/short1.png','pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('2', './assets/test/img-product/2/hair1.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('3', './assets/test/img-product/1/shirt1.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '

              ' . Article::getPreview('4', './assets/test/img-product/1/shirt2.png', 'pantalón corto', 'Tienda de ejemplo', 'description del producto...', '45$', true) . '
              
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
