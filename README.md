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

// Enable annotations for books
$wgGoogleRichCardsAnnotateBooks = true;

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

### Template:Book
```

### Usage of book template

== Livre ==
=== {{{name}}} ===

{{{description}}}



auteur: {{{author}}}


<book name="{{{name}}}" place="{{{place}}}" description="{{{description}}}" postalCode="{{{postalCode}}}" locality="{{{locality}}}" region="{{{region}}}" country="{{{country}}}" author="{{{author}}}" streetaddress="{{{streetAddress}}}" offer="{{{offer}}}" offerURL="{{{offerURL}}}" offerPrice="{{{offerPrice}}}" offerCurrency="{{{offerCurrency}}}" offerAvailability="{{{offerAvailability}}}" validFrom="{{{validFrom}}}" image="{{{image}}} />

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
|offerAvailability=InStock
|performer=Some awesome person
|offerPrice=5
|offerCurrency=USD
|offerURL=http://example.com/test-event
|image=http://example.com/logo.png
|validFrom=2018-06-01T10:00+03:00
}}
```

### Usage of Event template
```
{{Book
|name=La reconstruction de la ville de Valenciennes (1940-1959)
|place=Valenciennes
|description=Après l'incendie du 22 mai 1940, Valenciennes située en zone interdite est sous la tutelle de l'Autorité administrative allemande. André Muffang, Commissaire à la Reconstruction, désigne Valenciennes comme l'une des premières villes sinistrées à reconstruire. Le plan de reconstruction de la ville et l'aménagement de son agglomération est établi sous Vichy par l'éminent architecte-urbaniste Albert Laprade. Il est reconnu d'utilité publique le 24 juin 1943 et vise à consacrer la ville comme capitale du Hainaut afin d'en faire, à terme le centre d'un nouveau département. Ce plan ne sera pas remis en question après guerre.
|postalCode=000000
|locality=Valenciennes
|region=Haut de France
|country=Fr
|offerAvailability=InStock
|author=Jean-Marie Richez
|offerPrice=26
|offerCurrency=EUR
|offerURL=http://www.histoire-valenciennes-cahv.fr/index.php?title=La_reconstruction_de_la_ville_de_Valenciennes_(1940-1959)
|image=http://www.histoire-valenciennes-cahv.fr/Memoires/public/journals/1/cover_issue_60_fr_CA.jpg
|validFrom=2018-06-01T10:00+03:00
}}
```
