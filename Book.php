<?php
/**
 * GoogleRichCards
 * Google Rich Cards metadata generator for Books
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
use PPFrame;

if (!defined('MEDIAWIKI')) {
  echo("This is a Mediawiki extension and doesn't provide standalone functionality\n");
  die(1);
}

class Book {
  /**
   * @var static Book instance for Signleton pattern
   */
  public static $instance;

  /**
   * Singleon pattern getter
   *
   * @return Book
   */
  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new Book();
    }

    return self::$instance;
  }

  public function parse($text, $params = [], Parser $parser, PPFrame $frame) {
    $o = array();
    foreach($params as $k => $v) {
      $o[$k] = $parser->recursiveTagParse($v, $frame);
    }
    return '<!-- BookData:'.json_encode($o).' -->';
  }

  public function render(OutputPage &$out) {
    if($out->isArticle()) {
      foreach($this->getData($out->mBodytext) as $book) {
        $e = json_decode($book);

        $book = array(
           '@context'    => 'http://schema.org',
           '@type'       => 'book',
           'name'        => $this->getMetadataField($e, 'name', 'name'),
           'publisher' => $e->{'publisher'},
           'numberOfPages' => $e->{'numberOfPages'},
           'isbn' => $e->{'isbn'},
           'bookEdition' => $e->{'bookEdition'},
           'description' => $this->getMetadataField($e, 'description', 'description'),
           'image'       => $this->getRawURL($e->{'image'}),
        );



        if($e->{'author'}) {
          $book['author'] = array(
            '@type'   => 'PerformingGroup',
            'name'    => $this->getMetadataField($e, 'author', 'author'),
          );

          if($e->{'offer'}) {
            $book['offers'] = array(
              '@type'         => 'Offer',
              'url'           => $this->getRawURL($e->{'offerurl'}),
              'price'         => $this->getMetadataField($e, 'offerPrice', 'offerprice'),
              'priceCurrency' => $this->getMetadataField($e, 'offerCurrency', 'offercurrency'),
              'availability'  => $this->getItemAvailability($e->{'offeravailability'}),
              'validFrom'     => $this->getMetadataField($e, 'validFrom', 'validfrom'),
            );
          }
        }

        $out->addHeadItem(
          'GoogleRichCardsBook_'.$e->{'name'},
          '<script type="application/ld+json">'.json_encode($book).'</script>'
        );
      }
    }
  }

  private function getData($pageText) {
		$matches = preg_match_all('/<!-- BookData:(\{(.*)\}) -->/m', $pageText, $extracted);

		return $extracted[1];
  }
  
  private function getRawURL($htmlLink) {
    $matches = preg_match_all('/((https?:\\/\\/)([a-z0-9\.\/_-]+))/i', $htmlLink, $extracted);

    return $extracted[0][0];
  }

  private function getItemAvailability($value) {
    switch ($value) {
      case "Discontinued":
        return "http://schema.org/Discontinued";
      case "InStock":
        return "http://schema.org/InStock";
      case "InStoreOnly":
        return "http://schema.org/InStoreOnly";
      case "LimitedAvailability":
        return "http://schema.org/LimitedAvailability";
      case "OnlineOnly":
        return "http://schema.org/OnlineOnly";
      case "OutOfStock":
        return "http://schema.org/OutOfStock";
      case "PreOrder":
        return "http://schema.org/PreOrder";
      case "PreSale":
        return "http://schema.org/PreSale";
      case "SoldOut":
        return "http://schema.org/SoldOut";
    }
    return "";
  }

  private function getMetadataField($obj, $field, $name) {
    $value = $obj->{$name};
    if ($value == '{{{'.$field.'}}}') {
      return "";
    }
    return $value;
  }
}

?>
