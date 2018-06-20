<?php
require_once '../repository/GallerieRepository.php';
require_once '../repository/BildRepository.php';
$data = new GallerieRepository();

$galleries = $data->getPublicGalleries();
for($i = 0; $i < sizeof($galleries);$i++){
    $getBild = new BildRepository();
    echo "<a href='" .$GLOBALS['appurl'] . "/galerie/show/" . $galleries[$i]->id . "' >";
    echo "<div class='galerieBox'>";
    echo "<img src='" . $galleries[$i]->path . "/" . $getBild->getRandomBildName($galleries[$i]->id) ."'>";
    echo "<h4>" . $galleries[$i]->gname . "</h4>";
    echo "</div>";
    echo "</a>";

}
