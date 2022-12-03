<?php 

class ViewComponent {

   /**
   * @var string código HTML de la vista o componente de clase
   */
private string $code;

public function __construct(string $code) {
  $this->code = $code;
}

 /**
   * Código HTML de la vista o componente 
   * @return string Devuelve el código HTML del componente o vista
   */
  public function getCode(): string
  {
    return $this->code;
  }  
}
