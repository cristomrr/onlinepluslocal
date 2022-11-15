<?php

/**
 * Clase encargada de la creación de formularios
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Form
{

  private string $code;

  /**
   * Construye el código del formulario con la configuración pasada por parámetros
   *
   * @param array $form 
   *              (string) name: Campo oculto que identificará el formulario al enviar al servidor
   *              (string) legend: Título del formulario
   *              (string) url: Ruta del archivo donde se enviará el formulario
   *              (string) method: Método de envío del formulario (post o get)
   *              (bool) fieldset: Agrega o no la línea exterior del formulario
   * @param array $inputs Colección de datos de los campos a introducir en el formulario: 
   *              (string) component: Tipo de etiqueta (input, textarea)
   *              (string) id: Identificador de la etiqueta del campo y del la etiqueta label asociada 
   *              (string) label: Texto de la etiqueta label asociada
   *              (string) type: Tipo de campo (text, password, email,...) (necesario si component == input)
   *              (array) options: Opciones si las hubiese (opcional)
   * @param array $btnSubmit 
   *              (string) text: Texto del botón de envío del formulario
   *              (string) icon: Icono del botón de envío del formulario
   * @param string $extra Código extra a agregar al final de los campos del formulario
   */
  public function __construct(
    array $form,
    array $inputs,
    array $btnSubmit,
    string $extra
  ) {

    $this->code = '<form action="' . $form["url"] . '" method="' . $form["method"] . '" class="form">';
    $this->code .= ($form["fieldset"]) ? '<fieldset>' : '';
    $this->code .= '<legend class="global-title">' . $form["legend"] . '</legend>';
    $this->code .= '<input type="text" name="formname" id="formname" class="display-none" value="' . $form["name"] . '"/>';
    foreach ($inputs as $input) {
      switch ($input['component']) {
        case 'input':
          $this->code .= self::getInput($input['id'], $input['label'], $input['type']);
          break;
        case 'textarea':
          $this->code .= self::getTextarea($input['id'], $input['label'], $input['options']);
          break;
      }
    }
    $this->code .= $extra;
    $this->code .= self::getBtnSubmit($btnSubmit['text'], $btnSubmit['icon']);
    $this->code .= ($form["fieldset"]) ? '</fieldset>' : '';
    $this->code .= '</form>';
  }


  /**
   * Crea el código HTML de un campo de formulario.
   *
   * @param string $id Nombre identificador del campo de formulario
   * @param string $label Nombre del campo que será visualizado por el usuario
   * @param string $type Tipo de campo de formulario. Ejemplos: text, password, tel, email,...
   * @return string Código HTML con el campo para ser insertado en un formulario
   */
  private function getInput(string $id, string $label, string $type): string
  {
    return '<label for="' . $id . '">
                ' . $label . '
                <input type="' . $type . '" name="' . $id  . '" id="' . $id  . '" />
                </label>';
  }


  /**
   * Crea el código HTML de un textarea de formulario.
   *
   * @param string $id Nombre identificador del textarea de formulario
   * @param string $label Nombre del textarea que será visualizado por el usuario
   * @param array $options Opciones del textarea:
   *               cols: Tamaño en columnas
   *               rows: Tamaño en filas
   * @return string Código HTML con el campo para ser insertado en un formulario
   */
  private function getTextarea(string $id, string $label, array $options): string
  {
    return '<label for="' . $id . '">' . $label . '
              <textarea
                name="' . $id . '"
                id="' . $id . '"
                cols="' . $options["cols"] . '"
                rows="' . $options["rows"] . '" 
              ></textarea>
            </label>';
  }



  /**
   * Crea el código HTML del botón de envío del formulario.
   *
   * @param string $id Nombre identificador del campo de formulario
   * @param string $label Nombre del campo que será visualizado por el usuario
   * @param string $type Tipo de campo de formulario. Ejemplos: text, password, tel, email,...
   * @return string Código HTML con el campo para ser insertado en un formulario
   */
  private function getBtnSubmit(string $text, string $icon): string
  {
    $code = '<button type="submit">' . $text;
    $code .= ($icon !== "")
      ? '<span class="material-symbols-outlined">' . $icon . '</span>'
      : '';
    $code .= '</button>';

    return $code;
  }

  /**
   * Código HTML del componente Header para insertar en el documento
   *
   * @return string Devuelve el código HTML con el Header del documento
   */
  public function getCode(): string
  {
    return $this->code;
  }
}