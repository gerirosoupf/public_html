<?php
require "globals.inc.php";
$outfile = $_SESSION["outfile"];

//echo $outfile;
header("Content-Type: text/plain");
header("Content-Disposition: attachment, filename=$outfile");
readfile($outfile);
?>

