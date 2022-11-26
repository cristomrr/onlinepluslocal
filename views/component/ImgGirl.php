<?php

/**
 * Clase encargada del la creación del componente imagen de una chica de compras con un globo de texto que pasamos por parámetro para informar al usuario.
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class ImgGirl extends ViewComponent
{
  private const IMG_GIRL = './assets/img/girl.png';

  /**
   * Prepara el código del componente
   *
   * @param string $text Texto que se agrega al bocadillo de texto de la imagen
   */
  public function __construct(string $text)
  {
    $code = '<div class="girl-box">
                        <img class="imggirl" src="' . self::IMG_GIRL . '" alt="Mujer de compras dando un mensaje" />
                          <foreignObject x="20" y="90" width="150" height="200" class="text">
                            <p xmlns="http://www.w3.org/1999/xhtml">' . $text . '</p>
                          </foreignObject>
                    </div>';

    parent::__construct($code);
  }
}
