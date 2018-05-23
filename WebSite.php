<?php
/**
 * GoogleRichCards
 * Google Rich Cards metadata generator for WebSites search
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
use Title;

if (!defined('MEDIAWIKI')) {
  echo("This is a Mediawiki extension and doesn't provide standalone functionality\n");
  die(1);
}

class WebSite {
  /**
   * @var static Article instance to use for Singleton pattern
   */
  private static $instance;

  /**
   * @var Title current instance of Title received from global $wgTitle
   */
  private $title;

  /**
   * @var string Server URL received from global $wgServer
   */
  private $server;

  /**
   * Singleon pattern getter
   *
   * @return WebSite
   */
  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new WebSite();
    }

    return self::$instance;
  }

  /**
   * Class constructor
   */
  public function __construct() {
    global $wgLogo, $wgServer, $wgSitename, $wgTitle;

    $this->title = $wgTitle;
    $this->server = $wgServer;
  }

  /**
   * Render head item with metadata for Google Rich Snippet
   *
   * @param OutputPage OutputPage instance referencce
   */
  function render(OutputPage &$out) {
    if($this->title instanceof Title && $this->title->isContentPage()) {
      $website = array(
        '@context'        => 'http://schema.org',
        '@type'           => 'WebSite',
        'url'             => $this->server,
        'potentialAction' => array(
          '@type'       => 'SearchAction',
          'target'      => $this->server.'/index.php?search={search_term_string}',
          'query-input' => 'required name=search_term_string',
        )
      );

      $out->addHeadItem(
        'GoogleRichCardsWebSite',
        '<script type="application/ld+json">'.json_encode($website).'</script>'
      );
    }
  }
}

?>
