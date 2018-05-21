# mediawiki-GoogleRichCards
MediaWiki extension to generate Google Rich Cards metadata for article pages

mediawiki.org extension page: https://www.mediawiki.org/wiki/Extension:GoogleRichCards

# Features
The extension adds Google Rich Card JSON-LD metadata to each "content page" of your mediawiki:

```
  <script type="application/ld+json">
  {
     "@context": "http://schema.org",
     "@type": "Article",
     "mainEntityOfPage": {
       "@type": "WebPage",
       "@id": "<current page URL>"
     },
     "author": {
       "@type": "Person",
       "name": "<first revision author>"
      },
     "headline": "<current page title>",
     "dateCreated": "2016-05-04T08:20:51+00:00",
     "datePublished": "2016-05-04T08:20:51+00:00",
     "discussionUrl": "<current page talk link>",
     "dateModified": "2016-06-05T01:12:10+00:00",
     "image": {
       "@type": "ImageObject",
       "url": "<article image>",
       "height": <height>,
       "width": <width>
     },
     "publisher": {
       "@type": "Organization",
       "name": "<wiki name>",
       "logo": {
         "@type": "ImageObject",
         "url": "<logo url made of $wgServer + $wgLogo>"
       }
     },
     "description": "<page title>",
   }
   </script>
```

# Installation

```
require_once "$IP/extensions/GoogleRichCards/GoogleRichCardsArticle.php";
```
