<?php

class Pake_FileUtils
{
  static function mkdir($path, $mode=0775)
  {
    if (!file_exists($path)) {
      mkdir($path, $mode, true);
    }
  }

  static function rmdir($path)
  {
    if (file_exists($path))
    {
      $d = dir($path);
      while(($f = $d->read()) !== false)
      {
        if ($f == '.' or $f == '..') continue;
        
        if (is_dir("$path/$f"))
        {
          self::rmdir("$path/$f");
          rmdir("$path/$f");
        }
        else {
          unlink("$path/$f");
        }
      }
      $d->close();
    }
  }
}
?>
