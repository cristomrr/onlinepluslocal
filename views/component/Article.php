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
   * @param string $id Identificador del artículo para ser localizado en la base de datos
   * @param string $img Imagen del artículo
   * @param string $title Nombre descriptivo del artículo
   * @param string $shop Tienda que lo vende
   * @param string $description Descripción del artículo
   * @param string $price Precio del artículo
   * @param boolean $isLike Indica si lo tiene en favoritos el usuario que hizo la consulta
   * @return string código HTML con el preview del artículo
   */
  public static function getPreview(
    string $id,
    string $img,
    string $title,
    string $shop,
    string $description,
    string $price,
    bool $isLike = false
  ): string {
    $article = '<div class="card">
                        <picture id="' . $id . '">
                            <img src="' . $img . '" alt="Imagen del producto" />
                        </picture>
                        <div class="info-card">
                            <p><span class="title">Producto: </span>' . $title . '</p>
                            <p><span class="title">Tienda: </span>' . $shop . '</p>
                            <p><span class="title">Descripción: </span>' . $description . '</p>
                            <p class="data">
                            <span class="price">' . $price . '</span>';

    //        TODO: realizar acción al pulsar para info del artículo y del botón de favorito
    $article .= ($isLike)
      ? '<span class="material-symbols-outlined favorite like">favorite</span>'
      : '<span class="material-symbols-outlined favorite">favorite</span>';

    $article .= '</p></div></div>';

    return $article;
  }
}
