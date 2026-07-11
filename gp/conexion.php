<?php
$conn=mysqli_connect ("localhost", "tlatoani_tlatoanitickets",
"Tlatoanitickets2020#") or die('Cannot connect to the database because: ' . mysqli_error());
mysqli_select_db ($conn, "tlatoani_tlatoanitickets");
?>