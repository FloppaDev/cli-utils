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
    $match = trim($match);
    echo "$file:$line:$column \t$match"."\n";
}
