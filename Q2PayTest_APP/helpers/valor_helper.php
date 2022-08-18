<?php

function randomWithDecimal($min, $max, $decimal = 0) {
  $scale = pow(10, $decimal);
  return mt_rand($min * $scale, $max * $scale) / $scale;
}

?>