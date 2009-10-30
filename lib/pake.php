<?php

namespace Pake;

class Pake
{
  protected $command = 'default';
  protected $args    = array();
  
  static protected $desc  = '';
  static protected $tasks = array();
  
  function __construct()
  {
    if ($_SERVER['argc']) {
      $this->parse_arguments(array_slice($_SERVER['argv'], 1));
    }
  }
  
  protected function parse_arguments($args)
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
      $task = self::$tasks[$this->command];
      $func = is_string($task['func']) ? str_replace(':', '\\', $task['func']) : $task['func'];
      
      if (is_callable($func)) {
        call_user_func_array($func, $this->args);
      }
      else {
        echo "Error: no such task '$func'\n";
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
    foreach(self::$tasks as $task => $data)
    {
      echo "  ".str_pad($task, $length)."  ".
        str_replace("\n", "\n".str_repeat(' ', $length + 4), wordwrap($data['desc'], 79 - $length - 4))."\n";
    }
    echo "\n";
  }
  
  static function desc($desc)
  {
    self::$desc = $desc;
  }
  
  static function task($task, $func=null)
  {
    self::$tasks[$task] = array(
      'desc' => self::$desc,
      'func' => ($func === null) ? $task : $func,
    );
    self::$desc = '';
  }
}

?>
