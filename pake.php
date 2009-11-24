<?php

if (!file_exists("{$_SERVER['PAKE_HOME']}/Pakefile")) {
  echo "Error: missing Pakefile.\n";
}

include __DIR__.'/lib/pake.php';
include __DIR__.'/lib/file_utils.php';

function desc($desc='') {
  Pake::desc($desc);
}

function task($task, $func=null) {
  Pake::task($task, $func);
}

function pake($args)
{
  if (!is_array($args)) {
    $args = preg_split('/\s+/', $args, PREG_SPLIT_NO_EMPTY);
  }
  $pake = new Pake($args);
  $pake->run();
}

include "{$_SERVER['PAKE_HOME']}/Pakefile";
$pake = new Pake(array_slice($_SERVER['argv'], 1));
$pake->run();

?>
