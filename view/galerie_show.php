<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 10:13
 */


if(isset($_SESSION['uid'])) {
    if($uid == $_SESSION['uid']) {
        $button = new ButtonBuilder();
        echo $button->label('Bild hinzufügen')->name('bild Hinzufügen')->type('link')->class('btn-success')->link("/bild/edit/{$id}");
        echo $button->label('Gallerie Löschen')->name('Gallerie Löschen')->type('link')->class('btn-success')->link("/galerie/delete/{$id}");
        echo $button->label('Gallerie Bearbeiten')->name('Gallerie Bearbeiten')->type('link')->class('btn-success')->link("/galerie/add/{$id}");
        echo "<br/>";
        echo $beschreibung;
        echo "<div class='pull-right'>";
        if($public) {
            echo "öffentlich ";
        }else {
            echo "privat ";
        }
        echo "<a href='" .$GLOBALS['appurl'] . "/galerie/add/{$id}'>ändern?</a></div>";
        echo "<br/>";
    }

}
for($i = 0; $i < sizeof($bilder);$i++){
    echo "<a href='". $GLOBALS['appurl'] . "/" . $path . "/" . $bilder[$i]->bname . "' >";
    echo "<img src='". $GLOBALS['appurl'] . "/" . $path . "/Thumbnail-" . $bilder[$i]->bname . "'/>";
    echo "<h4>" . $bilder[$i]->bezeichnung . "</h4>";
    echo "</a>";

}
