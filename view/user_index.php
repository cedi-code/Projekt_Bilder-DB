<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 10:42
 */
    $lblClass = "col-md-2";
    $eltClass = "col-md-4";
    $btnClass = "btn btn-success";

    $button = new ButtonBuilder();
    echo $button->label('Galerie Hinzufügen')->name('bild')->type('link')->class('btn-success')->link("/galerie/add");
    echo $button->label('Benutzerdaten ändern')->name('change')->type('link')->class('btn-success')->link("/benutzer/doEdit");

    echo "<h2>Galerien:</h2>";
    for($i = 0; $i < sizeof($galleries);$i++){
        echo "<a href='" .$GLOBALS['appurl'] . "/galerie/show/" . $galleries[$i]->id . "' >";
        echo "<img src='" . $galleries[$i]->path . "/profile.JPG'/>";
        echo "<h4>" . $galleries[$i]->gname . "</h4>";
        echo "</a>";

    }
