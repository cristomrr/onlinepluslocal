<?php

class Errors extends ViewComponent
{
  private const TITLE = '¡Ups! Ha habido un error';
  private const IMG = 'server/assets/img/error.png';

  public function __construct(string $msg)
  {
    $code = '<div class="content-error">
              <h1 class=error-title>' . self::TITLE . '</h1>
              <section class="error-img">
                <picture>
                  <img src="' . self::IMG . '" alt="aviso de error">
                </picture>
              </section>

              <section class="error-msg">
                <p>' . $msg . '</p>
              </section>';

    parent::__construct($code);
  }
}
