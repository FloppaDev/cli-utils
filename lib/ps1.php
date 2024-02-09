<?php

date_default_timezone_set('Europe/Paris');
@date_default_timezone_set(trim(@file_get_contents('/etc/timezone')));

$now = new DateTime;
$g = dechex($now->format('g'));
$i = $now->format('i');

$cwd = getcwd();
$dir_components = array_reverse(explode('/', $cwd));
$dir = @$dir_components[0];
$depth = dechex(count($dir_components) - 1);
$depth = $depth > 0 ? $depth : 0;

$tty = [];
exec('tty', $tty);
$tty = @$tty[0];
$tty = dechex(@array_reverse(explode('/', $tty))[0]);

$user = [];
exec('id -u', $user);
$user = @$user[0];

$d = "\001$(tput sgr0)\002";
$b = "\001$(tput setaf 0 setab 6)\002";
$p = "\001$(tput setaf 0 setab 5)\002";
$w = "\001$(tput setaf 0 setab 7)\002";

$t = $user == 0 
    ? "\001$(tput bold setaf 5)\002" 
    : "\001$(tput bold setaf 4)\002";

$i1 = substr($i, 0, 1);
$i2 = substr($i, 1, 1);

echo 
    $b . $tty.
    $p . $g.
    $w . $i1.
    $p . $i2.
    $b . $depth.
    $d .
    ' '.
    $t . $dir.
    $d .
    ' ';

