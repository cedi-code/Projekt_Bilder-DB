<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 18.05.2018
 * Time: 08:40
 */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";

$form = new Form($GLOBALS['appurl']."/bild/edit/" . $gid);
$button = new ButtonBuilder();


echo $form->input()->label('Bild Name:')->name('name')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Bezeichnung')->name('bez')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Bild:')->name('pic')->type('file')->lblClass($lblClass)->eltClass($eltClass);

if($gid == 0) {
    echo $form->input()->label('Gallerie')->name('gid')->type('text')->lblClass($lblClass)->eltClass($eltClass);
}else {
    echo $form->input()->name('gid')->type('hidden')->value($gid);
}

echo $button->start($lblClass, $eltClass);
echo $button->label('Add')->name('sendBild')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
if($err !== null ) {
    echo "<p class='errMsg'>" . $err . "</p>";
}