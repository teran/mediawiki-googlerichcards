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
$wgExtensionCredits['validextensionclass'][] = array(
  'name' => 'GoogleRichCards',
  'author' =>'Igor Shishkin',
  'url' => 'https://github.com/teran/mediawiki-GoogleRichCards'
);

if ( !defined( 'MEDIAWIKI' ) ) {
  echo( "This is a Mediawiki extension and doesn't provide standalone functionality\n" );
  die(1);
}

function GoogleRichCardsArticle(&$out) {
  global $wgLogo, $wgServer, $wgSitename, $wgTitle;
  if($wgTitle instanceof Title && $wgTitle->isContentPage()) {
    $ctime = DateTime::createFromFormat('YmdHis', $wgTitle->getEarliestRevTime());
    $mtime = DateTime::createFromFormat('YmdHis', $wgTitle->getTouched());
    if($ctime) {
      $created_timestamp = $ctime->format('c');
    } else {
      $created_timestamp = '0';
    }

    if($mtime) {
      $modified_timestamp = $mtime->format('c');
    } else {
      $modified_timestamp = '0';
    }


    $first_revision = $wgTitle->getFirstRevision();
    if($first_revision) {
      $author = $first_revision->getUserText();
    } else {
      $author = 'None';
    }

    $image = key($out->getFileSearchOptions());
    if($image && $image_object = wfFindFile($image)) {
      $image_url = $image_object->getFullURL();
      $image_width = $image_object->getWidth();
      $image_height = $image_object->getHeight();
    } else {
      $image_url = $wgServer.$wgLogo; // Mediawiki logo to be used by default
      $image_width = 135; // Default max logo width
      $image_height = 135; // Default max logo height
    }

    $article = array(
      '@context'         => 'http://schema.org',
      '@type'            => 'Article',
      'mainEntityOfPage' => array(
        '@type' => 'WebPage',
        '@id'   => $wgTitle->getFullURL(),
      ),
      'author'           => array(
        '@type' => 'Person',
        'name'  => $author,
      ),
      'headline'         => $wgTitle->getText(),
      'dateCreated'      => $created_timestamp,
      'datePublished'    => $created_timestamp,
      'dateModified'     => $modified_timestamp,
      'discussionUrl'    => $wgServer.'/'.$wgTitle->getTalkPage(),
      'image'            => array(
        '@type'  => 'ImageObject',
        'url'    => $image_url,
        'height' => $image_height,
        'width'  => $image_width,
      ),
      'publisher'        => array(
        '@type' => 'Organization',
        'name'  => $wgSitename,
        'logo'  => array(
          '@type' => 'ImageObject',
          'url'   => $wgServer.$wgLogo,
        ),
      ),
      'description'      => $wgTitle->getText(),
    );

    $out->addHeadItem(
      'GoogleRichCardsArticle',
      '<script type="application/ld+json">'.json_encode($article).'</script>'
    );
  }
}

$wgHooks['BeforePageDisplay'][] = 'GoogleRichCardsArticle';

?>
