<?php

/**
 * Clase encargada de la vista Head del sitio
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Head
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;

  /**
   * Constructor para la creación del componente Head
   */
  public function __construct()
  {
    $this->code = '<head>
                    <meta charset="UTF-8" />
                    <link rel="icon" type="image/svg+xml" href="./asset/favicon.png" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <title>OnlinePlusLocal</title>

                    <!-- styles -->
                    
                    <link rel="stylesheet" href="./styles/style.css">

                    <!-- google fonts -->
                    
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

                    <!-- fonts -->

                    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">

                    <link rel="preconnect" href="https://fonts.googleapis.com">

                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap" rel="stylesheet">

                    <!-- icons  -->
                    
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
                    
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
                </head>';
  }

  /**
   * Contiene el contenido del Head completo de todo el sitio web
   *
   * @return string Código HTML de Head para ser insertado en el documento
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
