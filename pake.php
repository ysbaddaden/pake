<?php

if (isset($_SERVER['PAKE_HOME'])) {
  chdir($_SERVER['PAKE_HOME']);
}
if (!file_exists('Pakefile')) {
  echo "Error: missing Pakefile.\n";
}

include __DIR__.'/lib/pake.php';
include __DIR__.'/lib/file_utils.php';

function desc($desc='') {
  \Pake\Pake::desc($desc);
}

function task($task, $func=null) {
  \Pake\Pake::task($task, $func);
}

include 'Pakefile';
$pake = new \Pake\Pake();
$pake->run();

?>