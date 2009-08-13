<?php
/**
 * Wrap the GeSHi library to use it transparently in symfony
 *
 * @author Romain Dorgueil <romain.dorgueil@symfony-project.com>
 * @link http://qbnz.com/highlighter/
 */

class sfEasySyntaxHighlighterHelper extends GeSHi
{
  static protected
    $plugin_path = null;

  static protected
    $renderInstance = null;

  /**
   * render - real helper function
   *
   * @param  string $source
   * @param  string $language
   * @return string
   */
  static public function render($source, $language)
  {
    if (is_null(self::$renderInstance))
    {
      self::$renderInstance = new self($source, $language);
    }
    else
    {
      self::$renderInstance->set_language($language);
      self::$renderInstance->set_source($source);
    }

    return preg_replace("#\n&nbsp;</pre>#m", '</pre>', self::$renderInstance->parse_code());
  }

  public function __construct($source, $language)
  {
    parent::__construct($source, $language);
  }

  public static function getPluginPath()
  {
    if (is_null(self::$plugin_path))
    {
      self::$plugin_path = realpath(dirname(__FILE__).'/../../');
    }

    return self::$plugin_path;
  }

  /**
   * This functions hacks the GeSHi::set_language_path method to use symfony's path
   *
   * @param string $path
   * @param boolean $override
   */
  function set_language_path ($path, $override=false)
  {
    static $_path = null;

    if ($override)
    {
      parent::set_language_path($path);
    }
    else
    {
      if ($_path === null)
      {
        $_path = self::getPluginPath().'/lib/vendor/geshi/geshi/';
      }

      $this->language_path = $_path;
      $this->set_language($this->language);
    }
  }

  /**
   * Returns an associative array of GeSHi language identifier => Human readable language name
   */
  public static function getLanguages()
  {
    static $result = null;

    if ($result === null)
    {
      $cache_file = sfConfig::get('sf_cache_dir').'/sfEasySyntaxHighlighterLanguages.cache.php';

      if (!file_exists($cache_file))
      {
        $files = sfFinder::type('file')->name('*.php')->in(self::getPluginPath().'/lib/vendor/geshi/geshi/');
        $result = array();

        foreach ($files as $file)
        {
          require($file);

          $result[basename($file, '.php')] = $language_data['LANG_NAME'];
        }
        asort($result);

        file_put_contents($cache_file, serialize($result));
      }
      else
      {
        $result = unserialize(file_get_contents($cache_file));
      }
    }

    return $result;
  }
}
