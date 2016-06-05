# mediawiki-GoogleRichCards
MediaWiki extension to generate Google Rich Cards metadata for article pages

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
               "name": "Teran"
              },
             "headline": "<current page title>",
             "dateCreated": "2016-05-04T08:20:51+00:00",
             "datePublished": "2016-05-04T08:20:51+00:00",
             "discussionUrl": "<current page talk link>",
             "dateModified": "2016-06-05T01:12:10+00:00",
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
require_once "$IP/extensions/GoogleRichCards/GoogleRichCards.php";
```
