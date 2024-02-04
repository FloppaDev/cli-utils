<?php

require_once(__DIR__.'/common.php');

$ch = raw_read();

if (ctype_xdigit($ch)) {
    $i = hexdec($ch);
    echo "printf '< '; fg %$i";
}
else if (strpos('+-', $ch) !== false) {
    echo "printf '< '; fg $ch";
}
