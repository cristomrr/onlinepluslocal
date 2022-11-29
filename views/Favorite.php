<?php

/**
 * Clase que crea la vista del buscador de artículos favoritos.
 */
class Favorite extends ViewComponent
{
  /**
   * Construcción de la vista Búsqueda
   * 
   * @param array $url Rutas de enlace, como al archivo principal del servidor para formularios
   * @param array $articles Colección con los favoritos del usuario
   */
  public function __construct(array $url, array $articles = [])
  {
    $imgGirl = new ImgGirl('¡Ohh! que cosas te gustan');

    $code = '<section class="search">
                    <div class="girl">
                      ' . $imgGirl->getCode() . '
                    </div>
                  </section>';

    $code .= '<section class="result-search">
                      <h4 class="global-title-plane">Artículos favoritos: ' . count($articles) . '</h4>
                      <div class="articles">';

    if (count($articles) !== 0) {
      foreach ($articles as $k => $v) {
        $code .= Article::getPreview($v, true);
      }
    } else {
      $code .= '<p class=zero-articles>No tienes artículos favoritos</p>';
    }

    $code .= '</div></section>';

    parent::__construct($code);
  }
}
