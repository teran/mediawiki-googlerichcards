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

### Download code
```
git clone https://github.com/teran/mediawiki-GoogleRichCards.git <mediawiki path>/extensions/GoogleRichCards
```

### LocalSettings.php
```
// Load extension
wfLoadExtension('GoogleRichCards');

// Enable annotations for articles
$wgGoogleRichCardsAnnotateArticles = true;

// Enable annotations for events
$wgGoogleRichCardsAnnotateEvents = true;

// Enable WebSite annotations
$wgGoogleRichCardsAnnotateWebSite = true;
```

### Template:Event
```
<event name="{{{name}}}" startDate="{{{startDate}}}" endDate="{{{endDate}}}" place="{{{place}}}" description="{{{description}}}" postalCode="{{{postalCode}}}" locality="{{{locality}}}" region="{{{region}}}" country="{{{country}}}" performer="{{{performer}}}" />
```

Please note, you're free to update this template in order to setup events publishing in your own flavour

### Usage of Event template

```
{{Event
|name=Track day
|startDate=2018-06-01T10:00+03:00
|endDate=2018-06-01T20:00+03:00
|place=Moscow Raceway
|description=First track day in June
|postalCode=000000
|locality=Moscow district
|region=District of Volokolamsk
|streetAddress=95th km of Novorizhskoe highway (М9)
|country=RU
}}
```
