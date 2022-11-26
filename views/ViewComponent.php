<?php 

class ViewComponent {

   /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
private string $code;

public function __construct(string $code) {
  $this->code = $code;
}

 /**
   * Código HTML del componente Header
   *
   * @return string Devuelve el código HTML del componente o vista
   */
  public function getCode(): string
  {
    return $this->code;
  }  

}