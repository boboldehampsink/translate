DEPRECATED - Translate plugin for Craft CMS [![Build Status](https://travis-ci.org/boboldehampsink/translate.svg?branch=master)](https://travis-ci.org/boboldehampsink/translate) [![Code Coverage](https://scrutinizer-ci.com/g/boboldehampsink/translate/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/boboldehampsink/translate/?branch=develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/boboldehampsink/translate/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/boboldehampsink/translate/?branch=develop)
=================

Plugin that allows you to translate your website.

Features:
- Reads Craft::t(), Craft.t() and ""|t()
- Saves translations in own plugin translations folder
- Friendly UI (Select locale, search, select location, filter files, browse paths)
- Register your own translation sources with hook "registerTranslateSources"

Todo:
- Better UI (Show filepath, more locations)
- Google Translate support

Important:
The plugin's folder should be named "translate"

Deprecated
=================

With the release of Craft 3 on 4-4-2018, this plugin has been deprecated. You can still use this with Craft 2 but you are encouraged to use (and develop) a Craft 3 version. At this moment, I have no plans to do so.

Development
=================
Run this from your Craft installation to test your changes to this plugin before submitting a Pull Request
```bash
phpunit --bootstrap craft/app/tests/bootstrap.php --configuration craft/plugins/translate/phpunit.xml.dist --coverage-text craft/plugins/translate/tests
```

Changelog
=================
### 0.4.2 ###
- Add node_modules to excluded vendor folders (thanks to @tcsehv)

### 0.4.1 ###
- All service code is now fully covered by unit tests

### 0.4.0 ###
- Added Craft 2.5 compatibility

### 0.3.4 ###
- Added support for finding translatable strings in object notation
- Added a MIT license

### 0.3.3 ###
- Only init with local stored locale when there is any, else init with default instead of empty - this prevented saving in some occasions

### 0.3.2 ###
- Added the ability to read the translate tag when setting variables in twig

### 0.3.1 ###
- Verify matched translatable files as valid source

### 0.3.0 ###
- Added support for nested plugin and template sources
- Added JSON, Atom and RSS support

### 0.2.9 ###
- Added getCsrfInput function to forms

### 0.2.8 ###
Warning! This version is updated for Craft 2.3 and does NOT work on Craft 2.2

### 0.2.7 ###
- Fixed a bug where opening twig files would not match any expression

### 0.2.6 ###
- Added support for opening .twig files

### 0.2.5 ###
- Don't encode table attribute html, closing issue #2

### 0.2.4 ###
- Merge translations so we don't lose translations, fixing issue #1

### 0.2.3 ###
- Added a "registerTranslateSources" hook to add translate sources

### 0.2.2 ###
- Allow more filters after |translate

### 0.2.1 ###
- Enforce UTF-8 encoding on CSV download

### 0.2 ###
- Added ability to easily select a locale
- Added ability to search for words/translations
- Added ability to look in a specific location
- Added ability to upload updated translations (csv)
- Added ability to download translations (csv)

### 0.1 ###
- Initial push to GitHub
