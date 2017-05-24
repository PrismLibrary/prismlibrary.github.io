Website for Prism Library project
=======

The website for Prism Library project was developed under the CakePHP Framework 2.0 and its responsive design is helped by the Unsemantic CSS framework.

Frameworks
----------------

[CakePHP](https://book.cakephp.org/2.0/en/index.html) - PHP framework

[Unsemantic](https://unsemantic.com/) - CSS framework

Languages
------------

The website is available in English and Japanese.
The default language is English and all the HTML code has to be written first in English.

To translate sentences, edit the following file:
```
/app/Locale/{language}/LC_MESSAGES/core.po
```

Note: after any change on core.po, make sure you clean tmp files located in `/app/tmp/cache/persistent/`

Cautions
------------

**Files you can not change**
All the website's content (pages, images etc.) are located in `/app/` directory and you should only handle files are in this directory.
Do not modificate any file nor directory outsite `/app/`.

**Tmp files**
It is needed to set written permission on **tmp** directory and on any file and directory located in:
```
/app/tmp/
```