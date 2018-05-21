<?php
/**
 * GoogleRichCards
 * Google Rich Cards metadata generator for Articles
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

class Article {
  /**
   * @var static Article instance to use for Singleton pattern
   */
  private static $instance;

  /**
   * @var Title current instance of Title received from global $wgTitle
   */
  private $title;

  /**
   * @var string Site name received from global $wgSitename
   */
  private $sitename;

  /**
   * @var string Server URL received from global $wgServer
   */
  private $server;

  /**
   * @var string Wiki logo path received from global $wgLogo
   */
  private $logo;

  /**
   * Singleon pattern getter
   *
   * @return Article
   */
  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new Article();
    }

    return self::$instance;
  }

  /**
   * Class constructor
   */
  public function __construct() {
    global $wgLogo, $wgServer, $wgSitename, $wgTitle;

    $this->title = $wgTitle;
    $this->sitename = $wgSitename;
    $this->server = $wgServer;
    $this->logo = $wgLogo;
  }

  /**
   * Return creation time or 0 from current Article
   *
   * @return int
   */
  public function getCTime() {
    $ctime = \DateTime::createFromFormat('YmdHis', $this->title->getEarliestRevTime());
    if($ctime) {
      return $ctime->format('c');
    }
    return 0;
  }

  /**
   * Return modification time or 0 from current Article
   *
   * @return int
   */
  public function getMTime() {
    $mtime = \DateTime::createFromFormat('YmdHis', $this->title->getTouched());
    if($mtime) {
      return $mtime->format('c');
    }
    return 0;
  }

  /**
   * Return first image and it' resolution from the current Article
   *
   * @param OutputPage OutputPage instance referencce
   * @return array
   */
  public function getIllustration(OutputPage &$out) {
    $image = key($out->getFileSearchOptions());
    if($image && $image_object = wfFindFile($image)) {
      $image_url = $image_object->getFullURL();
      $image_width = $image_object->getWidth();
      $image_height = $image_object->getHeight();
    } else {
      $image_url = $this->server.$this->logo; // Mediawiki logo to be used by default
      $image_width = 135; // Default max logo width
      $image_height = 135; // Default max logo height
    }

    return array($image_url, $image_width, $image_height);
  }

  /**
   * Render head item with metadata for Google Rich Snippet
   *
   * @param OutputPage OutputPage instance referencce
   */
  function render(OutputPage &$out) {
    if($this->title instanceof Title && $this->title->isContentPage()) {
      $mtime = $this->getMtime();

      $created_timestamp = $this->getCTime();
      $modified_timestamp = $this->getMTime();

      $first_revision = $this->title->getFirstRevision();
      if($first_revision) {
        $author = $first_revision->getUserText();
      } else {
        $author = 'None';
      }

      $image = $this->getIllustration($out);

      $article = array(
        '@context'         => 'http://schema.org',
        '@type'            => 'Article',
        'mainEntityOfPage' => array(
          '@type' => 'WebPage',
          '@id'   => $this->title->getFullURL(),
        ),
        'author'           => array(
          '@type' => 'Person',
          'name'  => $author,
        ),
        'headline'         => $this->title->getText(),
        'dateCreated'      => $created_timestamp,
        'datePublished'    => $created_timestamp,
        'dateModified'     => $modified_timestamp,
        'discussionUrl'    => $this->server.'/'.$this->title->getTalkPage(),
        'image'            => array(
          '@type'  => 'ImageObject',
          'url'    => $image[0],
          'height' => $image_height[2],
          'width'  => $image_width[1],
        ),
        'publisher'        => array(
          '@type' => 'Organization',
          'name'  => $this->sitename,
          'logo'  => array(
            '@type' => 'ImageObject',
            'url'   => $this->server.$this->logo,
          ),
        ),
        'description'      => $this->title->getText(),
      );

      $out->addHeadItem(
        'GoogleRichCardsArticle',
        '<script type="application/ld+json">'.json_encode($article).'</script>'
      );
    }
  }
}

?>
