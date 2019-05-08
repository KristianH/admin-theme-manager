<?php
/**
 * Metadata version
 */

use KHVT\AdminThemeManager\Application\Controller\Admin\AdminList;
use KHVT\AdminThemeManager\Application\Controller\Admin\Base;
use KHVT\AdminThemeManager\Application\Controller\Admin\Main;
use KHVT\AdminThemeManager\Application\Controller\Admin\NavigationTree;
use KHVT\AdminThemeManager\Application\Controller\Admin\Settings;
use KHVT\AdminThemeManager\Core\Config;
use KHVT\AdminThemeManager\Core\Setup;

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
    'version'     => '1.0.1',
    'author'      => 'https://github.com/KristianH & https://github.com/vanilla-thunder/',
    'url'         => 'https://github.com/KristianH/admin-theme-manager/',
    'email'       => '',
    'extend'      => array(
        \OxidEsales\Eshop\Core\Config::class                                 => Config::class,
        \OxidEsales\Eshop\Core\Language::class                               => \KHVT\AdminThemeManager\Core\Language::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationTree::class => NavigationTree::class,
    ),
    'controllers' => array(
        'khvt_adminthememanager_application_controller_admin_adminlist' => AdminList::class,
        'khvt_adminthememanager_application_controller_admin_base'      => Base::class,
        'khvt_adminthememanager_application_controller_admin_main'      => Main::class,
        'khvt_adminthememanager_application_controller_admin_settings'  => Settings::class,
    ),
    'templates'   => array(
        'khvt_adminthememanager_application_views_admin_tpl_adminlist.tpl' => 'khvt/AdminThemeManager/Application/views/admin/tpl/adminlist.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_base.tpl'      => 'khvt/AdminThemeManager/Application/views/admin/tpl/base.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_main.tpl'      => 'khvt/AdminThemeManager/Application/views/admin/tpl/main.tpl',
        'khvt_adminthememanager_application_views_admin_tpl_settings.tpl'  => 'khvt/AdminThemeManager/Application/views/admin/tpl/settings.tpl',
    ),
    'events'      => array(
        'onActivate'   => Setup::class.'::install',
    ),
    'blocks'      => array(),
    'settings'    => array(),
);

