<?php
/**
 * GoogleRichCards
 * Google Rich Cards metadata generator
 *
 * PHP version 5.4
 *
 * @category Extension
 * @package  GoogleRichCards
 * @author   Igor Shishkin <me@teran.ru>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/teran/mediawiki-GoogleRichCards
 */

namespace MediaWiki\Extension\GoogleRichCards;

use OutputPage;
use Parser;
use Skin;

class Hooks {
  /**
	 * Handle meta elements and page title modification.
	 * @link https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 * @param OutputPage &$out The output page.
	 * @param Skin &$skin The current skin.
	 * @return bool
	 */
  public static function onBeforePageDisplay(OutputPage &$out, Skin &$skin) {
    global $wgGoogleRichCardsAnnotateArticles, $wgGoogleRichCardsAnnotateEvents;

    if($wgGoogleRichCardsAnnotateArticles) {
      $article = Article::getInstance();
      $article->render($out);
    }

    if($wgGoogleRichCardsAnnotateEvents) {
      $event = Event::getInstance();
      $event->render($out);
    }

    return true;
  }

  /**
   * Handle invocation of article parser
   *
   * @link https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
   * @param Parser &$parser The global parser.
   */
  public static function onParserFirstCallInit(Parser &$parser) {
    global $wgGoogleRichCardsAnnotateEvents;

    if($wgGoogleRichCardsAnnotateEvents) {
      $event = Event::getInstance();
      $parser->setHook('event', [$event, 'parse']);
    }
  }

}

?>
