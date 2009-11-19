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
  Pake::desc($desc);
}

function task($task, $func=null) {
  Pake::task($task, $func);
}

chdir($_SERVER['PAKE_HOME']);
include "{$_SERVER['PAKE_HOME']}/Pakefile";
$pake = new Pake();
$pake->run();

?>
