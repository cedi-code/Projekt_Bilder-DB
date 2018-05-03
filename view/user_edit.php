<?php
  /**
   * Registratons-Formular
   * Das Formular wird mithilfe des Formulargenerators erstellt.
   */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";





$form = new Form($GLOBALS['appurl']."/benutzer/doEdit");
$button = new ButtonBuilder();

echo $form->input()->label('Nickname')->name('nickname')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($usr);
echo $form->input()->label('E-Mail')->name('email')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($mail);
echo $form->input()->label('Passwort')->name('passwort')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('verify Passwort')->name('v_passwort')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $button->start($lblClass, $eltClass);
echo $button->label('Submit')->name('sendE')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
if($error != null) {
    echo $error;
}
?>
