<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 10:42
 */
    require_once '../repository/BildRepository.php';
    $lblClass = "col-md-2";
    $eltClass = "col-md-4";
    $btnClass = "btn btn-success";

    $button = new ButtonBuilder();

    echo $button->label('Galerie Hinzufügen')->name('bild')->type('link')->class('btn-success')->link("/galerie/add");
    echo $button->label('Benutzerdaten ändern')->name('change')->type('link')->class('btn-success')->link("/benutzer/doEdit");
    echo "</div>";
    echo "<div class='center-content'>";
    echo "<h2>Galerien:</h2>";
    for($i = 0; $i < sizeof($galleries);$i++){
        $getBild = new BildRepository();

        echo "<a href='" .$GLOBALS['appurl'] . "/galerie/show/" . $galleries[$i]->id . "' >";
        echo "<div class='galerieBox'>";
        echo "<img src='" . $galleries[$i]->path . "/" . $getBild->getRandomBildName($galleries[$i]->id) ."'>";
        echo "<h4>" . $galleries[$i]->gname . "</h4>";
        echo "</div>";
        echo "</a>";


    }
    echo "</div>";
    echo "<br/><br/>";
