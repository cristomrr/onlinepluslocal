<?php

class Article
{
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
