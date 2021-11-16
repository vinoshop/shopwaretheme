::# Shopware Vinoshop Theme

To start: ``docker-compose up -d``

### Links
* https://developer.shopware.com/docs/guides/plugins/themes/create-a-theme
* https://developer.shopware.com/docs/guides/plugins/plugins/storefront/customize-templates
* https://developer.shopware.com/docs/guides/plugins/plugins/storefront/add-custom-page

docker-compose exec shopware /bin/sh

### when you want to start developing
``bin/console theme:compile && bin/console assets:install && bin/console cache:clear``

### reload theme:
```
docker-compose exec shopware /bin/sh
bin/console cache:clear
```
or

``docker-compose exec shopware /bin/sh -c "bin/console cache:clear"``

if you changed js or scss:
``docker-compose exec shopware /bin/sh -c "bin/console theme:compile"``

Alternatively:
https://docs.dockware.io/development/watchers

if js or scss was changed:
``bin/console theme:compile && bin/console cache:clear``


### install theme:
```
docker-compose exec shopware /bin/sh
bin/console plugin:refresh
bin/console plugin:install --activate VinoshopTheme
bin/console theme:change
0
1
bin/console cache:clear
```

###Password for admin
```
Shopware
```
