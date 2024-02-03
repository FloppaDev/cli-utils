<?php

$cb = file('php://stdin');

$options = getopt('e:aFf');

$with_ext = @$options['e'];
$pick_all = isset($options['a']);
$ext_path = isset($options['f']);
$slash_ext_path = isset($options['F']);

foreach ($cb as $line) {
    $line = preg_replace('/[^a-zA-Z\d\/\._-]+/', ' ', $line);
    $words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($words as $word) {
        if (preg_match('/[^\w\d\/\._-]/', $word)) {
            continue;
        }

        if (file_exists($word)) {
            if ($ext_path && strpos('.', $word) === false) {
                continue;
            }

            if ($slash_ext_path && strpos('/', $word) === false) {
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

