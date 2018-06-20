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
        echo   "<div class=\"panel panel-default\"><div class=\"panel-body\"><span class='bigo'>" . $beschreibung . "</span></div></div>";

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
echo "<div class=\"row\">";
for($i = 0; $i < sizeof($bilder);$i++){

    //echo "<a href='". $GLOBALS['appurl'] . "/" . $path . "/" . $bilder[$i]->bname . "' >";
    //echo "<div class='imgBox'>";

    echo "<div class=\"column\">";
    echo "<img src='". $GLOBALS['appurl'] . "/" . $path . "/Thumbnail-" . $bilder[$i]->bname . "' onclick=\"openModal();currentSlide(".($i+1).")\"/ class=\"hover-shadow\">";
    echo "<h4>" . $bilder[$i]->bezeichnung . "</h4>";
    echo "</div>";
    //echo "</a>";

}
echo "</div>";
echo "<div id=\"myModal\" class=\"modal\">
  <span class=\"close cursor\" onclick=\"closeModal()\">&times;</span>

  <div class=\"modal-content\">";
for($i = 0; $i < sizeof($bilder);$i++){
    echo "<a class='ed' href='".$GLOBALS['appurl'] . "/bild/edit/{$id}?bid=". $bilder[$i]->id . "'><span class=\"close cursor\" style='right: 35px; top: -40px; font-weight: normal;'>&#x270E;</span></a>";
    echo "<a class='del' href='".$GLOBALS['appurl'] . "/bild/delete/". $bilder[$i]->id . "'><span class=\"close cursor\" style='right: 85px; top: -40px; font-weight: normal;'>&#9985;</span></a>";
    echo "<div class='mySlides'><div class='numbertext'>". ($i+1) . " / ".  sizeof($bilder). "</div>";
    echo "<img src='". $GLOBALS['appurl'] . "/" . $path . "/" . $bilder[$i]->bname . "'/>";
    // echo "<h4>" . $bilder[$i]->bezeichnung . "</h4>";
    echo "</div>";
    
}
echo "    <a class=\"prev\" onclick=\"plusSlides(-1)\">&#10094;</a>
    <a class=\"next\" onclick=\"plusSlides(1)\">&#10095;</a>";

for($o = 0; $o < sizeof($bilder);$o++ ) {
    echo "<div class=\"column\">
      <img class=\"demo\" src=\"" .$GLOBALS['appurl'] . "/" . $path . "/Thumbnail-" . $bilder[$o]->bname . "\" onclick=\"currentSlide(".($o +1) . ")\" alt=\"Nature\"></div>";
}

echo " </div>
</div>";
