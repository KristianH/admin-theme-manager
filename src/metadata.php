<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'             => 'admin-theme-manager',
    'title'          => 'Admin Theme Manager',
    'description'    => array(
        'de' => '',
        'en' => '',
    ),
    'thumbnail'      => 'picture.png',
    'version'        => '0.0.2',
    'author'         => 'https://github.com/KristianH & https://github.com/vanilla-thunder/',
    'url'            => 'https://github.com/KristianH/admin-theme-manager/',
    'email'          => '',
    'extend'         => array(
        \OxidEsales\Eshop\Core\Config::class                                 => \KHVT\AdminThemeManager\Core\Config::class,
        \OxidEsales\Eshop\Core\Language::class                               => \KHVT\AdminThemeManager\Core\Language::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationTree::class => \KHVT\AdminThemeManager\Application\Controller\Admin\NavigationTree::class,
    ),
    'controllers'   => array(
//        'controllerMapName'    => stdClass::class,
    ),
    'templates'      => array(
//        'template.tpl' => 'pathtotemplate.tpl',
    ),
    'events'         => array(
//        'onActivate' => stdClass::class . '::method',
//        'onDeactivate' => stdClass::class . '::method',
    ),
    'blocks'         => array(
//        array(
//            'template' => '',
//            'block'    => '',
//            'file'     => '',
//        ),
    ),
    'settings' => array(
//        array(
//            'group'     => '',
//            'name'      => '',
//            'type'      => '',
//            'value'     => ''
//        ),
    ),
);

