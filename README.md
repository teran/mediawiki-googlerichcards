# mediawiki-GoogleRichCards
MediaWiki extension to generate Google Rich Cards metadata for article pages

mediawiki.org extension page: https://www.mediawiki.org/wiki/Extension:GoogleRichCards

# Features
The extension adds Google Rich Card JSON-LD metadata to each "content page" of your MediaWiki installation.
Currently it supports the following types:

 * Article (status: stable)
 * WebSite (status: beta)
 * Event (status: alpha)

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
== Event ==
=== {{{name}}}

{{{description}}}


Date: {{{startDate}}}

Place: {{{place}}}

Address: {{{streetAddress}}}

Performer: {{{performer}}}


<event name="{{{name}}}" startDate="{{{startDate}}}" endDate="{{{endDate}}}" place="{{{place}}}" description="{{{description}}}" postalCode="{{{postalCode}}}" locality="{{{locality}}}" region="{{{region}}}" country="{{{country}}}" performer="{{{performer}}}" streetaddress="{{{streetAddress}}}" offer="{{{offer}}}" offerURL="{{{offerURL}}}" offerPrice="{{{offerPrice}}}" offerCurrency="{{{offerCurrency}}}" offerAvailability="{{{offerAvailability}}}" validFrom="{{{validFrom}}}" image="{{{image}}} />
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
