<?php

require_once(__DIR__.'/common.php');

$input = raw_read();

if ($input == '0') {
    $ch = '+';
    $i = $input;
}
else if (ctype_digit($input)) {
    $i = $ch = $input;
}
else if (strpos('+-', $input) !== false) {
    $i = $ch = $input;
}
else if (ctype_alpha($input)) {
    $ch = strtoupper($input);
    $i = ord($ch) - 55;
}
else {
    exit;
}

echo "printf ' < [$ch]'; fg $i > /dev/null";
