# Shopware Vinoshop Theme

[![deployment_stable](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_stable.yml/badge.svg)](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_stable.yml)
[![deployment_dev](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_dev.yml/badge.svg)](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_dev.yml)

To start: ``docker-compose up -d``

## Setup

How to install shopware: https://developer.shopware.com/docs/guides/installation/overview

How to install a theme in shopware: https://docs.shopware.com/en/shopware-6-en/extensions/myextensions

Next, create all the custom fields specified in [administration.md](administration.md).

Then you can start filling in all the custom fields. Their location is specified
in [administration.md](administration.md).

TODO @JakobMatijasevic how to setup landing page

Now you have to create in the administration sections for the homepage layout.

![img.png](img.png)

You have to create 4 sections and name them the following:

* landingpage_header --> this section contains the landingpage startImg and the text
    * now you have to add the following blocktypes:
        * image, full-sized
            * block-name: landingpage_top_bg_img
        * Text
            * block-name: landingpage_top_header
            * ![img_4.png](img_4.png)
* landingpage_products --> this section contains the header for popular products as well as popular products
    * blocks:
        * text
            * block-name: landingpage_products_header
        * product-slider
            * block-name: landingpage_products
* landingpage_categories --> contains 3 images and links of the categories
    * blocks:
        * three columns, captioned images
            * block-name: landingpage_categories
            * links: /Rotwein, /Weisswein, /Schaumwein
            * ![img_5.png](img_5.png)
* landingpage_winzer --> recommended winzer and 2 of his recommended wines
    * blocks:
        * Text:
            * block-name: landingpage_winzer_name
        * image, full-sized
            * block-name: landingpage_winzer_pic
        * product-slider
            * block-name: landingpage_winzer_products

After creating this page, you have to edit the already created index.html.twig file and create a twig file with the name
landingpage.html.twig You can find the index.html.twig file
here ``@VinoshopTheme/src/Resources/views/storefront/page/content/index.html.twig``

Add the following lines to your twig code in the index file:

```
//this will set the header margin to 0
{% if activeRoute == "frontend.home.page" %}
{% set large_header_margin = false %}
{% endif %}

//add into the already created twig block base_main_inner this
{% if activeRoute == "frontend.home.page" %}
{% sw_include '@VinoshopTheme/storefront/page/content/landingpage.html.twig' with {
cmsPage: page.cmsPage
} only %}
{% else %}
//put here the code that was here at the beginning
[...]
{% endif %}
```

Now create in the same folder as index the new file landingpage.html.twig.

Add the following

```html
{% set large_header_margin = false %}
{% block landingpage %}
{% if cmsPage %}
{% set landingpage_header = "" %}
{% set landingpage_products = "" %}
{% set landingpage_categories = "" %}
{% set landingpage_winzer = "" %}
<div class="cms-page">
    <div class="landingpage">
        {% for element in cmsPage.sections.elements %}
        {% if element.name == "landingpage_header" %}
        {% set landingpage_header = element %}
        {% elseif element.name == "landingpage_products" %}
        {% set landingpage_products = element %}
        {% elseif element.name == "landingpage_categories" %}
        {% set landingpage_categories = element %}
        {% elseif element.name == "landingpage_winzer" %}
        {% set landingpage_winzer = element %}
        {% endif %}
        {% endfor %}

        {% sw_include '@VinoshopTheme/storefront/page/content/startImg.html.twig' with {
        landingpage_header: landingpage_header
        } only %}

        {% sw_include '@VinoshopTheme/storefront/page/content/landingpageProducts.html.twig' with {
        landingpage_products: landingpage_products
        } only %}

        {% sw_include '@VinoshopTheme/storefront/page/content/landingpageCategories.html.twig' with {
        landingpage_categories: landingpage_categories
        } only %}

        {% sw_include '@VinoshopTheme/storefront/page/content/recommendedWinzer.html.twig' with {
        landingpage_winzer: landingpage_winzer
        } only %}
    </div>
</div>
{% endif %}
{% endblock %}
```

For readability the landingpage file has been split up into 4 different twig files. The following files (in the same
folder) need to be created:

* startImg.html.twig - loads the img and text, if you want to change its design you can certainly change the html part
  of the code
    * ```html
    {% block start_img %}
    {% if landingpage_header %}
        {% set img_block = '' %}
        {% set header_block = '' %}

        {% for block in landingpage_header.blocks %}
            {% if block.name == 'landingpage_top_bg_img' %}
                {% set img_block = block %}
            {% elseif block.name == 'landingpage_top_header' %}
                {% set header_block = block %}
            {% endif %}
        {% endfor %}

        {% if img_block %}
            {% for img in img_block.slots.elements|first.data.media.thumbnails.elements %}
                {% if img.width == 1920 %}
                    <div style="background-image: url({{ img.url }})"
                    class="landingpage-top">
                    <div class="landingpage-top-text container">
                        {{ header_block.slots.elements|first.data.content | raw }}
                        <a href="#products" class="display-5">
                            <button class="landingpage-top-text-button display-5">
                                Entdecken
                            </button>
                        </a>
                    </div>
                {% endif %}
            {% endfor %}
            </div>
            <span id="products"></span>
        {% endif %}
    {% endif %}
    {% endblock %}
    ```
* landingpageProducts.html.twig - loads the products
    * ```html
    {% block landingpagePrdoducts %}
    {% if landingpage_products %}
        {% set header_block = '' %}
        {% set products_block = '' %}

        {% for block in landingpage_products.blocks.elements %}
            {% if block.name == 'landingpage_products_header' %}
                {% set header_block = block %}
            {% elseif block.name == 'landingpage_products' %}
                {% set products_block = block %}
            {% endif %}
        {% endfor %}

        <div class="landingpage-products container">
            {% if header_block %}
                <div class="landingpage-products-flex">
                    <hr>
                    <h2 class="landingpage-products-header">
                        {{ header_block.slots.elements|first.data.content }}
                    </h2>
                    <hr>
                </div>
            {% endif %}
            {% if products_block %}
                <div class="landingpage-products-helper">
                    {% if products_block.slots.elements|first.data.products.elements|length > 0 %}
                        {% for product_element in products_block.slots.elements|first.data.products.elements %}
                            {% set product = product_element.data.product %}
                            {% do product %}
                            {% sw_include '@Storefront/storefront/component/product/card/box-standard.html.twig' with {
                                'product': product_element,
                            } %}
                        {% endfor %}
                    {% else %}
                        <p>Keine weiteren Produkte vorhanden</p>
                    {% endif %}
                </div>
            {% endif %}
        </div>
    {% endif %}
    {% endblock %}
    ```
* landingpageCategories.html.twig - loads the categories
    * ```html
    {% block landingpageCategories %}
    {% if landingpage_categories %}
        {% set category_slots = landingpage_categories.blocks.elements|first.slots.elements %}
        {% set category_text_center = '' %}
        {% set category_text_right = '' %}
        {% set category_text_left = '' %}
        {% set category_img_left = '' %}
        {% set category_img_right = '' %}
        {% set category_img_center = '' %}

        {% for category_slot in category_slots %}
            {% if category_slot.slot == 'center-text' %}
                {% set category_text_center = category_slot %}

            {% elseif category_slot.slot == 'right-text' %}
                {% set category_text_right = category_slot %}

            {% elseif category_slot.slot == 'left-text' %}
                {% set category_text_left = category_slot %}

            {% elseif category_slot.slot == 'left-image' %}
                {% set category_img_left = category_slot %}

            {% elseif category_slot.slot == 'right-image' %}
                {% set category_img_right = category_slot %}

            {% elseif category_slot.slot == 'center-image' %}
                {% set category_img_center = category_slot %}
            {% endif %}
        {% endfor %}

        {% if category_slots %}
            <div class="landingpage-categories container">
                {% if category_text_left and category_img_left %}
                    <div class="landingpage-categories-helper">
                        {% set text = category_text_left.data.content %}
                        {% sw_thumbnails 'category-th' with {
                            media: category_img_left.data.media,
                            attributes: {
                                class: 'landingpage-categories-category img-hover-brightness',
                                alt: 'Hintergrundbild der Kategorie ' ~ text
                            },
                            sizes: {
                                'default': '300px'
                            }
                        } %}
                        {{ text|raw }}
                    </div>
                {% endif %}
                {% if category_text_center and category_img_center %}
                    <div class="landingpage-categories-helper">
                        {% set text = category_text_center.data.content %}
                        {% sw_thumbnails 'category-th' with {
                            media: category_img_center.data.media,
                            attributes: {
                                class: 'landingpage-categories-category img-hover-brightness',
                                alt: 'Hintergrundbild der Kategorie ' ~ text
                            },
                            sizes: {
                                'default': '300px'
                            }
                        } %}
                        {{ text|raw }}
                    </div>
                {% endif %}
                {% if category_text_right and category_img_right %}
                    <div class="landingpage-categories-helper">
                        {% set text = category_text_right.data.content %}
                        {% sw_thumbnails 'category-th' with {
                            media: category_img_right.data.media,
                            attributes: {
                                class: 'landingpage-categories-category img-hover-brightness',
                                alt: 'Hintergrundbild der Kategorie ' ~ text
                            },
                            sizes: {
                                'default': '300px'
                            }
                        } %}
                        {{ text|raw }}
                    </div>
                {% endif %}
            </div>
        {% endif %}
    {% endif %}
    {% endblock %}
    ```
* landingpageWinzer.html.twig - loads the recommended winzer and his products
    * ```html
    {% block recommendedWinzer %}
    {% if landingpage_winzer %}
        <div class="landingpage-recommendation-header container">
            {% set landingpage_winzer_header = "" %}
            {% set winzer_slug = "" %}
            {% set landingpage_winzer_pic = {} %}
            {% set landingpage_winzer_products = {} %}
            {% for winzer_elem in landingpage_winzer.blocks.elements %}
                {% if winzer_elem.name == "landingpage_winzer_name" %}
                    {% set landingpage_winzer_header = winzer_elem.slots.elements|first.data.content %}
                {% elseif winzer_elem.name == "landingpage_winzer_products" %}
                    {% set landingpage_winzer_products = winzer_elem.slots.elements|first.data.products.elements %}
                    {% set winzer_slug = landingpage_winzer_products|first.manufacturer.customFields.vs_winzer_slug %}
                {% elseif winzer_elem.name == 'landingpage_winzer_pic' %}
                    {% set landingpage_winzer_pic = winzer_elem.slots.elements|first.data.media %}
                {% endif %}
            {% endfor %}


            <hr>
            <h2 class="landingpage-recommendation-header-size">
                <a href="{{ path('frontend.winzer.winzer', { 'slug' : winzer_slug }) }}">{{ landingpage_winzer_header }}</a>
            </h2>
            <hr>
        </div>
        <div class="landingpage-recommendation container">
            <div class="landingpage-recommendation-gray">
                {% sw_thumbnails 'recommended-winzer-th' with {
                    media: landingpage_winzer_pic,
                    attributes: {
                        class: 'landingpage-recommendation-winzer',
                        alt: 'Bild des vorgestellten Winzers'
                    },
                    sizes: {
                        'default': '800px'
                    }
                } %}
                <div class="landingpage-recommendation-products">
                    {% for product in landingpage_winzer_products %}
                        {% if loop.first %}
                            {% sw_include '@Storefront/storefront/component/product/card/box.html.twig' with {
                                'product': product
                            } %}
                            <div class="landingpage-recommendation-products-line"></div>
                        {% else %}
                            {% sw_include '@Storefront/storefront/component/product/card/box.html.twig' with {
                                'product': product
                            } %}
                        {% endif %}
                    {% endfor %}

                </div>
            </div>
        </div>
    {% endif %}
    {% endblock %}
    ```

Lastly a service needs to be created since the Products on the landingpage aren't loaded with their manufacturers name.

The service adds the products manufacturer on the even ProductsLoadedEvent. The Service should be called
AddManufacturerToHomePageProducts.php.

The service contains the following code:

```PHP
  <?php
declare(strict_types=1);

namespace VinoshopTheme\Storefront\Service;

//DO NOT FORGET TO IMPORT/USE ALL THE NEEDED NAMESPACES AND CLASSES

class AddManufacturerToHomePageProducts implements EventSubscriberInterface
{
    /**
     * @var EntityRepository
     */
    private $manufacturerRepository; //manufacturer Repository, mit dem auf die Datenbank Tabelle vom Winzer zugegriffen wird

    public function __construct(EntityRepository $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_LOADED_EVENT => 'onProductsLoaded'  //das verwendete Event, wenn ein Produkt geladen wird
        ];
    }

    //sobald das Produkt geladen wurde, wird diese methode ausgeführt
    public function onProductsLoaded(EntityLoadedEvent $event) {
        foreach($event->getEntities() as $entity) {
            if ($entity->getManufacturerId() == null)
                continue;
            //search criteria
            $criteria = new Criteria([$entity->getManufacturerId()]);

            //manufacturer wird gesucht
            /** @var ProductManufacturerEntity $currentManufacturer */
            $currentManufacturer = $this->manufacturerRepository
                ->search($criteria, $event->getContext())
                ->get($entity->getManufacturerId());

            //wenn der manufacturer nicht null ist wird dem produkt der manufacturer hinzugefügt
            if ($currentManufacturer != null)
                $entity->setManufacturer($currentManufacturer);
        }
    }
}

```

Now you have register it as a service in the ``services.xml`` file. Add the following:

```xml

<service id="VinoshopTheme\Storefront\Service\AddManufacturerToHomePageProducts">
    <argument type="service" id="product_manufacturer.repository"/>
    <tag name="kernel.event_subscriber"/>
</service>
```

So now that the landingpage is finished, we can create the manufacturer or winzerpage.

Firstly create winzerpageController ``@VinoshopTheme/src/Storefront/Controller/WinzerpageController.php`` :

Add the following Code:

```PHP
<?php declare(strict_types=1);

namespace VinoshopTheme\Storefront\Controller;

use [...]

/**
 * @RouteScope(scopes={"storefront"})
 */
class WinzerpageController extends StorefrontController
{
    private NavigationPageLoaderInterface $navigationPageLoader;
    private MenuOffcanvasPageletLoaderInterface $offcanvasLoader;
    private EntityRepository $manufacturerRepository;
    private string $slug;


    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader,
        MenuOffcanvasPageletLoaderInterface $offcanvasLoader,
        EntityRepository                    $manufacturerRepository
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
        $this->offcanvasLoader = $offcanvasLoader;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    //der slug wird in der Administration festgelegt
    /**
     * @Route("/winzer/{slug}", name="frontend.winzer.winzer", options={"seo"="true"}, methods={"GET"})
     */
    public function renderOneWinzer(Request             $request,
                                    Context             $context,
                                    SalesChannelContext $salesChannelContext,
                                    string              $slug
    ): ?Response
    {
        $this->slug = $slug;
        $page = $this->navigationPageLoader->load($request, $salesChannelContext);

        //Relationen werden hinzugefügt, dass ein manufacturer die restlichen benötigten sachen bekommt
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customFields.vs_winzer_slug', $slug));
        $criteria->addAssociation('products');
        $criteria->addAssociation('media');
        $criteria->addAssociation('products.cover');

        /** @var ProductManufacturerEntity $currentManufacturer */
        $currentManufacturer = $this->manufacturerRepository
            ->search($criteria, $context);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/winzerpage.html.twig',
            ['page' => $page, 'manufacturer' => $currentManufacturer],
        );
    }

    //wenn kein spez. winzer angezeigt werden soll
    /**
     * @Route("/winzer", name="frontend.winzer",
     *     options={"seo"="true"}, methods={"GET"})
     */
    public function renderAllWinzer(Request             $request,
                                    SalesChannelContext $salesChannelContext, Context $context): ?Response
    {
        $page = $this->navigationPageLoader
            ->load($request, $salesChannelContext);

        $criteria = new Criteria();
        $criteria->addAssociation('media');
        $criteria->addAssociation('customFields');

        /** @var ProductManufacturerEntity $currentManufacturer */
        $currentManufacturer = $this->manufacturerRepository->search($criteria, $context);

        return $this->renderStorefront('@Vinoshopheme/storefront/page/winzer/allWinzer.html.twig',
            ['page' => $page, 'manufacturers' => $currentManufacturer],
        );
    }
}
```

2nd register it as a controller in the services.xml file previously mentioned:

```xml

<service id="VinoshopTheme\Storefront\Controller\WinzerpageController" public="true">
    <argument type="service" id="Shopware\Storefront\Page\Navigation\NavigationPageLoader"/>
    <argument type="service" id="Shopware\Storefront\Pagelet\Menu\Offcanvas\MenuOffcanvasPageletLoader"/>
    <call method="setContainer">
        <argument type="service" id="service_container"/>
    </call>
    <argument type="service" id="product_manufacturer.repository"/>
</service>
```

Now you have to create the following twig templates ``@VinoshopTheme/src/Resources/views/storefront/page/winzer``:

* allWinzer.html.twig - shows all winzer in minimal card form
    * ```html
       {% sw_extends '@Storefront/storefront/base.html.twig' %}
       {% block base_main %}
           <div class="container">
               <h1 class="allWinzer-header">Unsere Winzer</h1>
               <div class="allWinzer d-flex flex-wrap justify-content-center align-content-start">
                   {% for manufacturer in manufacturers.entities.elements %}
                       <a class="allWinzer-hyperlink" href="{{ path('frontend.winzer.winzer', { 'slug' : manufacturer.customFields.vs_winzer_slug }) }}">
                           <div class="d-flex manufacturer-card">
                               {% if manufacturer.media %}
                                   {% sw_thumbnails 'winzer-logo-th' with {
                                       media: manufacturer.media,
                                       attributes: {
                                           alt: 'Logo von ' ~ manufacturer.name
                                       },
                                       sizes: {
                                           'default': '150px'
                                       }
                                   } %}
                               {% else %}
                                   <img src="https://via.placeholder.com/150" alt="{{ manufacturer.name }} - Logo">
                               {% endif %}
                               <div>
                                   <h4>{{ manufacturer.name }}</h4>
                                   <div class="description">{{ manufacturer.customFields['vs_winzer_story_p1']|raw }}</div>
                               </div>
                           </div>
                       </a>
                   {% endfor %}
               </div>
           </div>
       {% endblock %}
      ```
* winzerpage.html.twig - manufacturer specific page
    * ```html
        {% sw_extends '@Storefront/storefront/base.html.twig' %}
        {% set large_header_margin = false %}
        {% block base_main %}
            {% set manufacturer = manufacturer.entities.elements|first %}
            {% if manufacturer %}
                <div class="cms-page d-flex justify-content-center">
                    <div class="winzerpage">
                        <div class="winzerpage-img"
                             style="background-image: url('{{ manufacturer.customFields['vs_winzer_main_img'] }}')">
                            <div class="winzerpage-name container d-flex flex-column justify-content-center">
                                {# Daten #}
                                <h1>{{ manufacturer.name }}</h1>
                                <h2>{{ ('customFields.vs_winzer_bundesland.' ~ manufacturer.customFields['vs_winzer_bundesland'])|trans }}</h2>
                            </div>
        
                        </div>
                        <div class="winzerpage-story container d-flex justify-content-center flex-column">
                            {# beschreibung #}
                            <h3 class="winzerpage-story-header">{{ manufacturer.customFields['vs_winzer_story_header']|raw }}</h3>
                            <div class="d-flex justify-content-center">
                                <p class="winzerpage-story-content">
                                    {{ manufacturer.customFields['vs_winzer_story_p1']|raw }}
                                </p>
                            </div>
                            {# Quote #}
                            <div class="winzerpage-story-quote d-flex align-self-center flex-column">
                                <div id="winzerpage-story-quote-img"></div>
                                <div id="winzerpage-story-quote-centerer">
                                    <div id="winzerpage-story-quote-centerer-2">
                                        <p class="winzerpage-story-quote-header">
                                            "{{ manufacturer.customFields['vs_winzer_quote']|raw }}"</p>
                                        <p class="winzerpage-story-quote-name">
                                            -{{ manufacturer.customFields['vs_winzer_quote_name']|raw }}</p>
                                    </div>
                                </div>
                                <div id="winzerpage-story-quote-img-2"></div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <p class="winzerpage-story-content">
                                    {{ manufacturer.customFields['vs_winzer_story_p2']|raw }}
                                </p>
                            </div>
                        </div>
                        {% if manufacturer.customFields['vs_winzer_media'] or manufacturer.customFields['vs_winzer_video'] %}
                            <div class="winzerpage-media container">
                                {# Galerie #}
                                <div class="winzerpage-media-helper">
                                    {% if manufacturer.customFields["vs_winzer_imageGallery_header"] %}
                                        <h3 class="winzerpage-media-header">
                                            {% if manufacturer.customFields['vs_winzer_imageGallery_header'] %}
                                                {{ manufacturer.customFields['vs_winzer_imageGallery_header'] }}
                                            {% else %}
                                                ZU BESUCH BEIM WINZERHOF
                                            {% endif %}
                                        </h3>
                                    {% endif %}
                                    {# ImageSlider #}
                                    {% if  manufacturer.customFields["vs_winzer_media"] %}
                                        {% set images = manufacturer.customFields['vs_winzer_media']|split(';') %}
                                        {% set index = 0 %}
                                        <div id="imageSlider" class="carousel slide w-100" data-ride="carousel">
                                            <ol class="carousel-indicators ">
                                                {% for image in images %}
                                                    {% if loop.first %}
                                                        <li data-target="#imageSlider" data-slide-to="{{ index }}" class="active"></li>
                                                        {% set index = index + 1 %}
                                                    {% else %}
                                                        <li data-target="#imageSlider" data-slide-to="{{ index }}"></li>
                                                        {% set index = index + 1 %}
                                                    {% endif %}
                                                {% endfor %}
                                            </ol>
                                            <div class="carousel-inner ">
                                                {% set index = 0 %}
                                                {% for image in images %}
                                                    {% if loop.first %}
                                                        <div class="carousel-item active  ">
                                                            <img class="d-block mx-auto item-width" src="{{ image }}" class="d-block mx-auto"  alt="{{ image }}">
                                                            {#<div style="background-image: url('{{ image }}');"
                                                         class="d-block mx-auto carousel-divs carousel-item-max-height"></div>#}
                                                        </div>
                                                        {% set index = index + 1 %}
                                                    {% else %}
                                                        <div class="carousel-item">
                                                            {#<div style="background-image: url('{{ image }}');"
                                                         class=" carousel-item-max-height carousel-divs">
                                                    </div>#}
                                                            <img class="d-block mx-auto item-width" src="{{ image }}" alt="{{ image }}">
                                                        </div>
                                                        {% set index = index + 1 %}
                                                    {% endif %}
                                                {% endfor %}
                                            </div>
                                            <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#1a1818"
                                                     class="bi bi-chevron-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#1a1818"
                                                     class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    {% endif %}
        
                                    {# Video #}
                                    {% if manufacturer.customFields['vs_winzer_video'] %}
                                        <div class="winzerpage-media-video">
                                            <iframe class="winzerpage-media-video-size"
                                                    src="{{ manufacturer.customFields['vs_winzer_video'] }}"
                                                    title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                        </div>
                                    {% endif %}
                                </div>
                            </div>
                        {% endif %}
        
                        <div class="winzerpage-products container">
                            {# restliche Produkte #}
                            <h3 class="winzerpage-products-header">
                                {% if manufacturer.customFields['vs_winzer_products_header'] %}
                                    {{ manufacturer.customFields['vs_winzer_products_header'] }}
                                {% else %}
                                    PRÄMIERTE WEINE VON MAX MUSTERMANN
                                {% endif %}
                            </h3>
                            <div class="winzerpage-products-flexbox">
                                {# produkte #}
                                {% for product in manufacturer.products.elements %}
                                    {% sw_include '@Storefront/storefront/component/product/card/box-standard.html.twig' with {
                                        'product': product,
                                    } %}
                                {% endfor %}
                            </div>
                        </div>
        
                    </div>
                </div>
            {% else %}
                {% sw_include '@Storefront/storefront/page/error/error-404.html.twig' %}
            {% endif %}
        {% endblock %}
      ```
Lastly if you want to add email templates to the shopsystem, you have to go to the administration panel/settings/email-templates
    

### Links

* https://developer.shopware.com/docs/guides/plugins/themes/create-a-theme
* https://developer.shopware.com/docs/guides/plugins/plugins/storefront/customize-templates
* https://developer.shopware.com/docs/guides/plugins/plugins/storefront/add-custom-page

docker-compose exec shopware /bin/bash

### when you want to start developing

``./bin/build-storefront.sh``

### reload theme:

```
docker-compose exec shopware /bin/bash
bin/console cache:clear
```

or

``docker-compose exec shopware /bin/bash -c "bin/console cache:clear"``

if you changed js or scss:
``docker-compose exec shopware /bin/bash -c "bin/console theme:compile"``

Alternatively:
https://docs.dockware.io/development/watchers

if js or scss was changed:
``bin/console theme:compile && bin/console cache:clear``

### install theme:

```
docker-compose exec shopware /bin/bash
bin/console plugin:refresh
bin/console plugin:install --activate VinoshopTheme
bin/console theme:change
0
1
bin/console cache:clear
```

### Password for admin

```
shopware
```

### Password for MySQL

```
User: root
Password: root
Port: 3306
```
