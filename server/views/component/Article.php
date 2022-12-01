<?php

/**
 * Clase encargada de las vistas de los artículos
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Article
{
  /**
   * Contiene la vista previa del artículo, para los resultados de búsqueda o favoritos
   *
   * @param array $data Colección con los datos del artículo en un array asociativo
   * @param boolean $isLike Indica si lo tiene en favoritos el usuario que hizo la consulta
   * @return string código HTML con el preview del artículo
   */
  public static function getPreview(array $data, bool $isLike): string
  {
    $article = '<div class="card"
                        data-idarticle=' . $data["idarticle"] . '
                        data-city=' . $data["city"] . '
                        data-province=' . $data["province"] . '>

                  <div class="card-front">
                    <picture id="' . $data["idarticle"] . '">
                      <img src="' . $data["img"] . '" alt="Imagen del producto" />
                    </picture>
                    
                    
                    <div class="info-card-front">
                      <p><span class="title">Producto: </span>' . $data["name"] . '</p>
                      <p><span class="title">Descripción: </span>' . $data["description"] . '</p>
                      <p class="data">
                        <span class="price">' . $data["price"] . '</span>';

    $article .= ($isLike)
      ? '<span class="material-symbols-outlined favorite like" data-idarticle=' . $data["idarticle"] . '>favorite</span>'
      : '<span class="material-symbols-outlined favorite" data-idarticle=' . $data["idarticle"] . '>favorite</span>';

    $article .= '     </p>
                    </div>
                  </div>'; // end card-front

    $article .= '<div class="card-back">
                  <p><span class="title">Vendedor: </span>' . $data["username"] . '</p>
                  <p>
                    <span class="title">Teléfono: </span>
                    <a class="events" href=tel:' . $data["phone"] . '> ' . $data["phone"] . '</a>
                  </p>
                  <p>
                    <span class="title">Email: </span>
                    <a class="events" href=mailto:' . $data["email"] . '> ' . $data["email"] . '</a>
                  </p>
                  <p><span class="title">Dirección: </span>' . $data["address"] . '</p>
                  <p><span class="title">Localidad: </span>' . $data["city"] . '</p>
                  <p><span class="title">Provincia: </span>' . $data["province"] . '</p>
                </div>';

    $article .= '</div>'; // end card

    return $article;
  }
}
