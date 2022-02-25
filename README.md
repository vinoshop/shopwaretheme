# Shopware Vinoshop Theme

[![deployment_stable](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_stable.yml/badge.svg)](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_stable.yml)
[![deployment_dev](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_dev.yml/badge.svg)](https://github.com/vinoshop/shopwaretheme/actions/workflows/deployment_dev.yml)

To start: ``docker-compose up -d``

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
