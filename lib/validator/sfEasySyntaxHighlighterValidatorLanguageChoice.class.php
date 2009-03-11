<?php

/**
 * sfEasySyntaxHighlighterValidatorLanguageChoice validates a GeSHi language choice.
 *
 * @package
 * @version SVN: $Id$
 * @author  Romain Dorgueil <romain.dorgueil@symfony-project.com>
 * @license
 */
class sfEasySyntaxHighlighterValidatorLanguageChoice extends sfValidatorChoice
{
  protected function configure($options=array(), $messages=array())
  {
    parent::configure($options, $messages);

    $this->setOption('choices', array_keys(sfEasySyntaxHighlighterHelper::getLanguages()));
  }
}
