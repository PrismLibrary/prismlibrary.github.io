Website for Prism Library project
=======

The website for Prism Library project was written in HTML with a javascript translator script (english/japanese).

Languages
------------

The website is available in English and Japanese.

To translate sentences, edit the following file:
```
/lang/languages.json
```

Every new word or setence added to the HTML page has to be also added to **languages.json** file. For example, if you add the word "Home", it should be translated to all languages:
```
"en": {
	...
	"l_home": "Home",
	...
},
"jp": {
	...
	"l_home": "ホーム",
	...
}
```

Note: to maintain a pattern, the reference code has to begin with "l_". If the reference code has more than 2 word, if should be limited to 3 word. For example, for the sentence "It is a great clean website" should be `l_it_is_a`. If there is already the same code, use the next words (eg: `l_great_clean_website`)

Credits
------------

The website was originally design by [Rian Dutra](http://riandutra.com).