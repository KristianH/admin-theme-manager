<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'admin-theme-manager',
    'title'       => 'Admin Theme Manager',
    'description' => array(
        'de' => '',
        'en' => '',
    ),
    'thumbnail'   => 'picture.png',
    'version'     => '0.0.2',
    'author'      => 'https://github.com/KristianH & https://github.com/vanilla-thunder/',
    'url'         => 'https://github.com/KristianH/admin-theme-manager/',
    'email'       => '',
    'extend'      => array(
        \OxidEsales\Eshop\Core\Config::class                                 => \KHVT\AdminThemeManager\Core\Config::class,
        \OxidEsales\Eshop\Core\Language::class                               => \KHVT\AdminThemeManager\Core\Language::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationTree::class => \KHVT\AdminThemeManager\Application\Controller\Admin\NavigationTree::class,
    ),
    'controllers' => array(
        'khvt_adminthememanager_application_controller_admin_adminlist' => \KHVT\AdminThemeManager\Application\Controller\Admin\AdminList::class,
        'khvt_adminthememanager_application_controller_admin_base'      => \KHVT\AdminThemeManager\Application\Controller\Admin\Base::class,
        'khvt_adminthememanager_application_controller_admin_main'      => \KHVT\AdminThemeManager\Application\Controller\Admin\Main::class,
        'khvt_adminthememanager_application_controller_admin_settings'  => \KHVT\AdminThemeManager\Application\Controller\Admin\Settings::class,
    ),
    'templates'   => array(
        'khvt_adminthememanager_application_views_admin_tpl_adminlist.tpl' => 'khvt/AdminThemeManager/Application/views/admin/tpl/adminlist.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_base.tpl'      => 'khvt/AdminThemeManager/Application/views/admin/tpl/base.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_main.tpl'      => 'khvt/AdminThemeManager/Application/views/admin/tpl/main.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_settings.tpl'  => 'khvt/AdminThemeManager/Application/views/admin/tpl/settings.tpl',
    ),
    'events'      => array(),
    'blocks'      => array(),
    'settings'    => array(),
);

