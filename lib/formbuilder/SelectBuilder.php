<?php
  /**
   * Erstellt eine Dropdown-Liste für ein Formular.
   * Da die Werte für die Liste im allgemeinen dynamisch sind (z.B. aus einer Tabelle stammen),
   * wird das select-Tag nicht abgeschlossen. D.h. die <option>-Werte werden in der View generiert,
   * darauf wird das select-Tag mit end() abgeschlossen.
   */
  class SelectBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('label');
      $this->addProperty('name');
      $this->addProperty('value');
      $this->addProperty('lblClass');
      $this->addProperty('eltClass');
    }
    public function build()
    {

      $result = "<label class='{$this->lblClass} control-label' for='textinput'>{$this->label}</label>\n";
      if($this->value >= 1)  {
          $result .= "<input type='checkbox' checked name='{$this->name}' value='{$this->value}'>\n";
      }else {
          $result .= "<input type='checkbox' name='{$this->name}'>\n";
      }



      return $result;
    }
    public function end() {
	  $result  = "</select>\n";
	  $result .= "</div>\n";
	  $result .= "</div>\n";
	  return $result;
	}
  }
?>