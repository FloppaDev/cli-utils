<?php

$jobs = file('php://stdin');
$options = getopt('fa');

$list_files = isset($options['f']);

if (isset($options['a'])) {
    $list_files = false;
    $args_only = true;
}

$i = 0;

foreach ($jobs as $job) {
    [ $idx
    , $stat
    , $args
    ] = preg_split('/\s+/', preg_replace('/\n/', '', $job), 3);

    if (@$args_only) {
        echo "$args\n";
        continue;
    }

    $idx = preg_replace('/[\[\]]/', ' ', $idx);

    @[ $id
    , $prev
    ] = preg_split('/\s+/', $idx, 2, PREG_SPLIT_NO_EMPTY);

    $prev ??= ' ';

    if (preg_match('/^vim\s+\S+/', $args)) {
        $s = preg_split('/\s+/', $args, -1, PREG_SPLIT_NO_EMPTY);

        if (!empty($s)) {
            $args = @array_reverse($s)[0];
        }

        if ($list_files) {
            echo "$args\n";
        }
    }

    if ($list_files) {
        continue;
    }

    $indent = !$i++ ? ' >' : '  '; 

    $id = (int)$id;

    if ($id > 9) {
        $id = chr($id + 55);
    }

    echo "$indent [$id]$prev $args\n";
}
