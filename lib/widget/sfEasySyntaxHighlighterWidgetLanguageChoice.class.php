<?php

/**
 * sfEasySyntaxHighlighterWidgetLanguageChoice represents a GeSHi language choice widget.
 *
 * @package
 * @version SVN: $Id$
 * @author  Romain Dorgueil <romain.dorgueil@symfony-project.com>
 * @license
 */
class sfEasySyntaxHighlighterWidgetLanguageChoice extends sfWidgetFormChoice
{
  /**
   * configure
   *
   * @see sfWidgetFormChoice
   *
   * @param  array $options
   * @param  array $attributes
   * @return void
   */
  public function configure($options=array(), $attributes=array())
  {
    parent::configure($options, $attributes);

    $languages = sfEasySyntaxHighlighterHelper::getLanguages();
    $this->setOption('choices', $languages);
  }
}
