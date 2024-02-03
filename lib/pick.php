<?php

$cb = file('php://stdin');

$options = getopt('e:adf');

$with_ext = @$options['e'];
$pick_all = isset($options['a']);
$files = isset($options['f']);
$dirs = isset($options['d']);

if ($files) {
    $dirs = false;
}

foreach ($cb as $line) {
    $line = preg_replace('/[^a-zA-Z\d\/\._-]+/', ' ', $line);
    $words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($words as $word) {
        if (preg_match('/[^\w\d\/\._-]/', $word)) {
            continue;
        }

        if (file_exists($word)) {
            $f = is_file($word);

            if ((!$f && $files) || ($f && $dirs)) {
                continue;
            }

            if ($with_ext && !preg_match("/\.$with_ext$/", $word)) {
                continue;
            }

            echo "$word\n";

            if (!$pick_all) {
                exit;
            }
        }
    }
}

