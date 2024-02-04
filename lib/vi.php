<?php

if (!$location = @preg_split('/\s+/', @$argv[1], 1, PREG_SPLIT_NO_EMPTY)[0]) {
    exit;
}

@[ $path
, $line
, $char
] = preg_split('/[:@,;#]+/', $location, 3, PREG_SPLIT_NO_EMPTY);

$cmd = '';

if (!empty($line)) {
    $cmd = "normal ${line}gg";
}

if (!empty($char) && ($ch = (int)$char - 1) > 0) {
    $cmd .= "0${ch}l";
}

echo empty($cmd) 
    ? "vim $path"
    : "vim -c '$cmd' $path";
