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
   * @param string $idshop Tienda que lo vende
   * @param string $description Descripción del artículo
   * @param string $price Precio del artículo
   * @param boolean $isLike Indica si lo tiene en favoritos el usuario que hizo la consulta
   * @return string código HTML con el preview del artículo
   */
  public static function getPreview(array $data, bool $isLike): string
  {
    $article = '<div class="card data-idarticle='.$data["idarticle"].'">
                        <picture id="' . $data["idarticle"] . '">
                            <img src="' . $data["img"] . '" alt="Imagen del producto" />
                        </picture>
                        <div class="info-card">
                            <p><span class="title">Producto: </span>' . $data["name"] . '</p>
                            <p><span class="title">Tienda: </span>' . $data["username"] . '</p>
                            <p><span class="title">Descripción: </span>' . $data["description"] . '</p>
                            <p class="data">
                            <span class="price">' . $data["price"] . '</span>';

    //        TODO: realizar acción al pulsar para info del artículo y del botón de favorito
    $article .= ($isLike)
      ? '<span class="material-symbols-outlined favorite like" data-idarticle='.$data["idarticle"].'>favorite</span>'
      : '<span class="material-symbols-outlined favorite" data-idarticle='.$data["idarticle"].'>favorite</span>';

    $article .= '</p></div></div>';

    return $article;
  }
}
