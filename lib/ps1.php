<?php

date_default_timezone_set('Europe/Paris');
@date_default_timezone_set(trim(@file_get_contents('/etc/timezone')));

$now = new DateTime;
$g = dechex($now->format('g'));
$i = $now->format('i');

$cwd = getcwd();
$dir_components = array_reverse(explode('/', $cwd));
$dir = @$dir_components[0];
$depth = dechex(count($dir_components) - 2);
$depth = $depth > 0 ? $depth : 0;

#TODO fn in common to always read only 1st line of stdout
$tty = [];
exec('tty', $tty);
$tty = @$tty[0];
$tty = dechex(@array_reverse(explode('/', $tty))[0]);

$user = [];
exec('id -u', $user);
$user = @$user[0];

$d = '\033[0;37m';
$b = '\033[30;106m';
$p = '\033[30;105m';
$w = '\033[30;47m';

$t = $user == 0 ? '\033[1;95m' : '\033[1;94m';

$i1 = substr($i, 0, 1);
$i2 = substr($i, 1, 1);

echo "${b}${tty}${p}${g}${w}${i1}${p}${i2}${b}${depth}${d} ${t}${dir}${d} ";

