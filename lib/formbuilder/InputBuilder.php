<?php
  /**
   * Erstellt ein Input-Feld für ein Formular.
   * Der Typ ist beliebig (text, email, password), nur 1 Feld pro Zeile.
   */
  class InputBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('label');
      $this->addProperty('name');
      $this->addProperty('type');
      $this->addProperty('value', null);
      $this->addProperty('lblClass');
      $this->addProperty('eltClass');
      $this->addProperty('disabled');
    }
    public function build()
    {
        $ok = "enabled";
      if($this->disabled) {
          $ok = "disabled";
      }
      $result  = "<div class='form-group'>\n";
      $result .= "<label class='{$this->lblClass} control-label' for='textinput'>{$this->label}</label>\n";
      $result .= "<div class='{$this->eltClass}'>\n";
      $result .= "<input name='{$this->name}' type='{$this->type}' value='{$this->value}'  ". $ok  ." class='form-control'>\n";
      $result .= "</div>\n";
      $result .= "</div>\n";
      return $result;
    }
  }
?>