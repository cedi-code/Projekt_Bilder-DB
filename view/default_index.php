<?php
require_once '../repository/GallerieRepository.php';
$data = new GallerieRepository();

$galleries = $data->getPublicGalleries();
for($i = 0; $i < sizeof($galleries);$i++){
    echo "<a href='" .$GLOBALS['appurl'] . "/galerie/show/" . $galleries[$i]->id . "' >";
    echo "<img src='" . $galleries[$i]->path . "/profile.JPG'/>";
    echo "<h4>" . $galleries[$i]->gname . "</h4>";
    echo "</a>";

}
