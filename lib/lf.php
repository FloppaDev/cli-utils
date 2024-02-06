<?php

$json = mb_convert_encoding(stream_get_contents(STDIN), 'UTF-8', 'UTF-8');
$matches = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

foreach ($matches as $match) {
    ['file' => $file, 'matches' => $matches] = $match;

    foreach ($matches as $match) {
        ['line' => $line, 'column' => $column, 'match' => $match] = $match;
        format_match($file, $line, $column, $match);
    }
}

function format_match($file, $line, $column, $match) {
    $d = "\033[0;37m";
    $b = "\033[0;96m";
    $r = "\033[0;31m";
    $w = "\033[1;37m";

    $match = preg_replace('/[\x01-\x1F\x7F]/', '', trim($match));

    $space = str_repeat(' ', 3 - strlen("$file:$line:$column") % 2);

    echo "$b$file$w:$r$line$w:$r$column$d$space$match"."\n";
}
