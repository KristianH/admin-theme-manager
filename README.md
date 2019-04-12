# admin-theme-manager
Oxid eShop Admin Theme Manager for Oxid eShop V6

This repository contains a Oxid Eshop module to manage admin themes.
The admin theme management base on shop theme management.

## functions
- new admin menu item to manage admin themes
- extends shop classes:
  - \OxidEsales\Eshop\Core\Config
  - \OxidEsales\Eshop\Core\Language
  - \OxidEsales\Eshop\Application\Controller\Admin\NavigationTree
- de/activate stand-alone admin themes
- managing child themes

## how to install
```composer require khvt/admin-theme-manager```

## how to create a admin theme
1. create the theme folder in source/Application/views/{themeId}/
2. create the configuration file in source/Application/views/{themeId}/adminTheme.php
3. fill the adminTheme.php file with the theme parameters:
```
<?php
$themeParameter = [
    'id'          => 'admin_child',
    'title'       => 'Oxid Child Admin',
    'description' => 'This is OXID eShop\'s inofficial admin theme.',
    'thumbnail'   => 'theme.png',
    'version'     => '1',
    'parentTheme' => 'admin',
    'author'      => '<a href="http://www.oxid-esales.com" title="OXID eSales AG">OXID eSales AG</a>',
    'parentVersions' => array('1'),
    'settings'       => array(
        array(
            'group' => 'images',
            'name'  => 'aDetailImageSizes',
            'type'  => 'aarr',
            'value' => array(
                'oxpic1'  => '540*340',
                'oxpic2'  => '540*340',
                'oxpic3'  => '540*340',
                'oxpic4'  => '540*340',
                'oxpic5'  => '540*340',
                'oxpic6'  => '540*340',
                'oxpic7'  => '540*340',
                'oxpic8'  => '540*340',
                'oxpic9'  => '540*340',
                'oxpic10' => '540*340',
                'oxpic11' => '540*340',
                'oxpic12' => '540*340',
            ),
        ),
    ),
];
```
4. create the theme folder in source/out/{themeId}
5. create your required subfolders in source/Application/views/{themeId}/ (de, en, tpl, for example) and fill it with content :-)
