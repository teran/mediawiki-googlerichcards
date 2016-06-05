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
 * */
$wgExtensionCredits['validextensionclass'][] = array(
   'name' => 'GoogleRichCards',
   'author' =>'Igor Shishkin',
   'url' => 'https://github.com/teran/mediawiki-GoogleRichCards'
);

if ( !defined( 'MEDIAWIKI' ) ) {
  echo( "This is a Mediawiki extension and doesn't provide standalone functionality\n" );
  die(1);
}

function GoogleRichCards(&$out)
{
    global $wgLogo, $wgServer, $wgSitename, $wgTitle;
    if($wgTitle->isContentPage()) {
      $created_timestamp = DateTime::createFromFormat('YmdHis', $wgTitle->getEarliestRevTime());

      $out->addHeadItem(
          'GoogleRichCards',
          '<script type="application/ld+json">
          {
             "@context": "http://schema.org",
             "@type": "Article",
             "mainEntityOfPage": {
               "@type": "WebPage",
               "@id": "'.$wgTitle->getFullURL().'"
             },
             "headline": "'.$wgTitle.'",
             "dateCreated": "'.$created_timestamp->format('c').'",
             "datePublished": "'.$created_timestamp->format('c').'",
             "discussionUrl": "'.$wgServer.'/'.$wgTitle->getTalkPage().'",
             "publisher": {
               "@type": "Organization",
               "name": "'.$wgSitename.'",
               "logo": {
                 "@type": "ImageObject",
                 "url": "'.$wgServer.$wgLogo.'"
               }
             },
             "description": "'.$wgTitle->getText().'"
           }
           </script>');
         }
}

$wgHooks['BeforePageDisplay'][] = 'GoogleRichCards';

?>
