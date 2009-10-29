<?php

namespace Pake;

class Pake
{
  protected $command = 'default';
  protected $args    = array();
  
  static protected $tasks = array();
  
  function __construct()
  {
    if ($_SERVER['argc']) {
      $this->parse_args(array_slice($_SERVER['argv'], 1));
    }
  }
  
  protected function parse_args($args)
  {
    foreach($args as $i => $arg)
    {
      if (preg_match('/^([A-Z_]+)=(.*)$/', $arg, $match))
      {
        $_SERVER[$match[1]] = trim($match[2]);
        unset($args[$i]);
      }
    }
    
    if (!empty($args))
    {
      $this->command = array_shift($args);
      $this->args    = $args;
    }
  }
  
  function run()
  {
    if ($this->command != 'default')
    {
      $cmd = str_replace(':', '\\', $this->command);
      if (function_exists($cmd)) {
        call_user_func_array($cmd, $this->args);
      }
      else {
        echo "Error: no such task '$cmd'\n";
      }
    }
    else {
      $this->help();
    }
  }
  
  function help()
  {
    $length = 0;
    foreach(array_keys(self::$tasks) as $task) {
      $length = max($length, strlen($task));
    }
    
    ksort(self::$tasks);
    
    echo "Available tasks:\n\n";
    foreach(self::$tasks as $task => $desc)
    {
      echo "  ".str_pad($task, $length)."  ".
        str_replace("\n", "\n".str_repeat(' ', $length + 4), wordwrap($desc, 79 - $length - 4))."\n";
    }
    echo "\n";
  }
  
  static function task($task, $desc='')
  {
    self::$tasks[$task] = $desc;
  }
}

?>
