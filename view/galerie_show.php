<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 10:13
 */
$button = new ButtonBuilder();
echo $button->label('Bild hinzufügen')->name('bild Hinzufügen')->type('link')->class('btn-success')->link("/galerie");
echo $beschreibung;