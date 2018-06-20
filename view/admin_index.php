<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 20.06.2018
 * Time: 22:33
 */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";

echo "<div class='center-content'>";
for($i = 0; $i < sizeof($benutzer);$i++){
   echo "<a href='" .$GLOBALS['appurl'] . "/benutzer/" . $benutzer[$i]->id . "' >";
   echo $benutzer->nickname;
   echo "</a>";

}
echo "</div>";