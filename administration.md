## create product
field set: ``vs_product``

assign to ``products``

custom fields:
* ``vs_product_taste`` type ``text editor``
* ``vs_product_is_bio`` type ``active switch``
* ``vs_product_good_with`` type ``select field``
    * multi select
    * options:
        1. ``cheese``: ``Käse``
        2. ``red_meat``: ``Rotes Fleisch``
        2. ``light_meat``: ``Helles Fleisch``
        2. ``vegetables``: ``Gemüse``

## create winzer(videos, pictures, quote)
field set: ``vs_winzer``

assign to ``Manufactures``

custom fields:
* ``vs_winzer_slug`` type ``text field``
  * ``Position: `` 0
  * ``Label: `` Slug
  * ``Placeholder: `` winzer-poys

* ``vs_winzer_main_img`` type ``text field``
  * ``Position: `` 0
  * ``Label: `` Startbild
  * ``Placeholder: `` 'http://localhost/media/ec/2b/6a/1643302031/03_winzer_poys_vaterSohn.png'


* ``vs_winzer_media`` type ``Text field``
  * ``Position:``  1
  * ``Label:``     Bilder_URLs
  * ``Placeholder:`` 00_winzer_poys_main.jpg;01_winzer_poys.jpg;...
  * ``Help text: `` Gib die URLs mit Semicolon getrennt an; die URLs bekommst du aus dem MediaTab unter Manufacturers
  

* ``vs_winzer_bundesland`` type ``Select field``
  * ``Position: `` 2
  * ``Label: `` Bundesland
  * Bundeslandname : Bundeslandname 9x


* ``vs_winzer_story_header`` type ``text field``
    * ``Position:``  3
    * ``Label:``     1. Header - Story


* ``vs_winzer_story_p1`` type ``text editor``
    * ``Position:``  4
    * ``Label:``     1. Artikelteil
   

* ``vs_winzer_quote`` type ``Text field``
    * ``Position:`` 5     
    * ``Label:`` Zitat       
    

* ``vs_winzer_quote_name`` type ``Text field``
    * ``Position: `` 6
    * ``Label: `` Zitat_Urheber


* ``vs_winzer_story_p2`` type ``text editor``
    * ``Position:``  7
    * ``Label:``     2. Artikelteil


* ``vs_winzer_imageGallery_header`` type ``Text field``
  * ``Position: `` 8
  * ``Label:`` 2. Header - ImageGallery

* ``vs_winzer_video`` type ``text field``
  * ``Position: `` 9
  * ``Label: `` Video
  * ``Placeholder: `` youtube.com/embed/xy12adskdfja
  * ``Help Text: `` Hier bitte ein embed link reingeben

* ``vs_winzer_products_header`` type ``text field``
    * ``Position: `` 10
    * ``Label: `` 3. Header - Products
    * ``Help Text: `` Das ist der Header über den Produkten des Winzers (z.B.: Prämierte Weine von Lukas Poys)

## create legal
field set: ``vs_legal``

assign to ``sales channels``

custom fields:
* ``vs_legal_agbs`` type ``text editor``
* ``vs_legal_impressum`` type ``text editor``
* ``vs_legal_datenschutz`` type ``text editor``

