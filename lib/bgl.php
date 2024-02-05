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

    if (preg_match('/^vim\s+\S+/', $args) ) {
        $wd = [];

        if (preg_match('/(\S+)\s+\(wd:\s+(\S*?)\)$/', $args, $wd)) {
            $path = @$wd[1];
            $_wd = @$wd[2];
            $wd = str_replace('~', getenv('HOME'), $_wd);
            $cwd = getcwd();

            if (substr($wd, 0, strlen($cwd)) == $cwd) {
                $args = substr($wd, strlen($cwd) + 1)."/$path";
            }
            else if (substr($cwd, 0, strlen($wd)) == $wd) {
                $sub_dirs = substr_count($cwd, '/', 0) - substr_count($wd, '/', 0);
                $args = str_repeat('../', $sub_dirs).$path;
            }
            else {
                $args = "$_wd/$path";
            }
        }
        else {
            $s = preg_split('/\s+/', $args, -1, PREG_SPLIT_NO_EMPTY);

            if (!empty($s)) {
                $args = @array_reverse($s)[0];
            }
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
