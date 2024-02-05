<?php

$paths = json_decode(file_get_contents(__DIR__.'/../data/paths.json'));

$search = @$argv[1];
$match = null;

if (!$search) {
    goto out;
}

foreach ($paths as $path) {
    [$name, $path] = explode(':', $path);

    if ($name == $search) {
        $match = $path;
        break;
    }
    
    if (!$match && preg_match("/$search/", $name)) {
        $match = $path; 
    }
}

out:
    $match ??= join("\n", $paths);
    echo "$match\n";
