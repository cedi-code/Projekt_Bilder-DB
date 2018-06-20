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
if(isset($_GET['bid'])) {
    $form = new Form($GLOBALS['appurl']."/bild/edit/" . $gid . "?edit=" .$edit. "&bid=".$_GET['bid']);
}else {
    $form = new Form($GLOBALS['appurl']."/bild/edit/" . $gid . "?edit=" .$edit);
}

$button = new ButtonBuilder();


echo $form->input()->label('Bild Name:')->name('name')->type('text')->lblClass($lblClass)->value($bname)->eltClass($eltClass);
echo $form->input()->label('Bezeichnung')->name('bez')->type('text')->lblClass($lblClass)->value($bezeichnung)->eltClass($eltClass);
echo $form->input()->label('Bild:')->name('pic')->disabled($edit)->type('file')->lblClass($lblClass)->eltClass($eltClass);

if($gid == 0) {
    echo $form->input()->label('Gallerie')->name('gid')->type('text')->lblClass($lblClass)->eltClass($eltClass);
}else {
    echo $form->input()->name('gid')->type('hidden')->value($gid);
}

echo $button->start($lblClass, $eltClass);
echo $button->label('Submit')->name('sendBild')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
if($err !== null ) {
    echo "<p class='errMsg'>" . $err . "</p>";
}