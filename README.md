Translate plugin for Craft CMS
=================

Plugin that allows you to translate your website.

Features:
- Reads Craft::t(), Craft.t() and ""|t()
- Saves translations in own plugin translations folder
- Friendly UI (Select locale, search, select location, filter files)
- Register your own translation sources with hook "registerTranslateSources"

Todo:
- Better UI (Show filepath, more locations)
- Google Translate support

Important:
The plugin's folder should be named "translate"

Changelog
=================
###0.2.9###
- Added getCsrfInput function to forms

###0.2.8###
Warning! This version is updated for Craft 2.3 and does NOT work on Craft 2.2

###0.2.7###
- Fixed a bug where opening twig files would not match any expression

###0.2.6###
- Added support for opening .twig files

###0.2.5###
- Don't encode table attribute html, closing issue #2

###0.2.4###
- Merge translations so we don't lose translations, fixing issue #1

###0.2.3###
- Added a "registerTranslateSources" hook to add translate sources

###0.2.2###
- Allow more filters after |translate

###0.2.1###
- Enforce UTF-8 encoding on CSV download

###0.2###
- Added ability to easily select a locale
- Added ability to search for words/translations
- Added ability to look in a specific location
- Added ability to upload updated translations (csv)
- Added ability to download translations (csv)

###0.1###
- Initial push to GitHub