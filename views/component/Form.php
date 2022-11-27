<?php

/**
 * Clase encargada de la creación de formularios
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Form extends ViewComponent
{
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
   *              (string) type: Tipo de campo (text, password, email,...) (necesario si es input no tipo file)
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

    $code = '<form action="' . $form["url"] . '" method="' . $form["method"] . '" class="form">';
    $code .= ($form["fieldset"]) ? '<fieldset>' : '';
    $code .= '<legend class="global-title">' . $form["legend"] . '</legend>';
    $code .= '<input type="text" name="formname" id="formname" class="display-none" value="' . $form["name"] . '"/>';
    foreach ($inputs as $input) {
      switch ($input['component']) {
        case 'file':
          $code .= self::getInputFile($input['id'], $input['label'], $input['options']);
          break;
        case 'input':
          $code .= self::getInput($input['id'], $input['label'], $input['type']);
          break;
        case 'input-value':
          $code .= self::getInputValue($input['id'], $input['label'], $input['type'], $input['value']);
          break;
        case 'textarea':
          $code .= self::getTextarea($input['id'], $input['label'], $input['options']);
          break;
      }
    }
    $code .= $extra;
    $code .= self::getBtnSubmit($btnSubmit['text'], $btnSubmit['icon']);
    $code .= ($form["fieldset"]) ? '</fieldset>' : '';
    $code .= '</form>';

    parent::__construct($code);
  }

  private function getInputFile(string $id, string $label, string $options): string
  {
    return '<label for="' . $id . '">' . $label . '
              <input type="file"
                id="' . $id . '"
                name="' . $id . '"
                accept="' . $options . '">
            </label>';
  }


  /**
   * Crea el código HTML de un campo de entrada de texto del formulario.
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
   * Crea el código HTML de un campo de entrada de texto del formulario.
   *
   * @param string $id Nombre identificador del campo de formulario
   * @param string $label Nombre del campo que será visualizado por el usuario
   * @param string $type Tipo de campo de formulario. Ejemplos: text, password, tel, email,...
   * @param string $value Texto del atributo value del campo del input
   * @return string Código HTML con el campo para ser insertado en un formulario
   */
  private function getInputValue(string $id, string $label, string $type, string $value): string
  {
    return '<label for="' . $id . '">
                ' . $label . '
                <input type="' . $type . '" name="' . $id  . '" id="' . $id  . '" value="' . $value . '" />
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
}
