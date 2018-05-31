<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 11:08
 */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";


if(isset($gid)) {
    $form = new Form($GLOBALS['appurl']."/galerie/add/{$gid}");
    echo $form->input()->name('gid')->type('hidden')->value($gid);
}else {
    $form = new Form($GLOBALS['appurl']."/galerie/add");
}
$button = new ButtonBuilder();
echo $form->input()->label('Galerie Name:')->name('name')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($name);
echo $form->input()->label('Beschreibung')->name('description')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($descripttion);
echo $form->select()->label('Public')->name('isPublic');


echo $button->start($lblClass, $eltClass);
echo $button->label('submit')->name('sendGalerie')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
if($err !== null ) {
    echo "<p class='errMsg'>" . $err . "</p>";
}