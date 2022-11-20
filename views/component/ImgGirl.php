<?php

/**
 * Clase encargada del la creación del componente imagen de una chica de compras con un globo de texto que pasamos por parámetro para informar al usuario.
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class ImgGirl
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;
  public const IMG_GIRL = './assets/img/girl.png';

  /**
   * Constructor del componente HTML
   *
   * @param string $text Texto que se agrega al bocadillo de texto de la imagen
   * @return string Código HTML completo para ser insertado en el documento
   */
  public function __construct(string $text)
  {
    $this->code = '<div class="girl-box">
                        <img class="imggirl" src="' . self::IMG_GIRL . '" alt="Mujer de compras dando un mensaje" />
                          <foreignObject x="20" y="90" width="150" height="200" class="text">
                            <p xmlns="http://www.w3.org/1999/xhtml">' . $text . '</p>
                          </foreignObject>
                    </div>';
    // <span class="text">' . $text . '</span>
  }


  /**
   * Código HTML del componente ImgGirl
   *
   * @return string Devuelve el código HTML con la imagen para insertar en el documento
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
