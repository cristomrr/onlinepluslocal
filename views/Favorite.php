<?php

/**
 * Clase que crea la vista del buscador de artículos. Contiene:
 *  - Formulario de búsqueda
 *  - Resultados de artículos
 */
class Favorite
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
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
                  </section>';

    $this->code .= '<section class="result-search">
                      <h4 class="global-title-plane">4 artículos favoritos:</h4>
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
   * Devuelve el contenido HTML del la página contacto
   *
   * @return string Código HTML de la página Contacto para ser insertado
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
