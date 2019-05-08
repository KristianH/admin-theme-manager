<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Core\Config;
use OxidEsales\Eshop\Core\Module\ModuleList;

/**
 * Class NavigationTree
 *
 * @package KHVT\AdminThemeManager\Application\Controller\Admin
 */
class NavigationTree extends NavigationTree_parent
{
    /**
     * Returns array with paths + names ox menu xml files. Paths are checked
     *
     * @return array
     */
    protected function _getMenuFiles()
    {
        $filesToLoad = [];
        /** @var Config $config */
        $config     = $this->getConfig();
        $viewsPath  = $config->getViewsDir(true);
        $adminTheme = $config->getShopConfVar('sAdminTheme');

        $fullAdminDir = $viewsPath.$adminTheme.DIRECTORY_SEPARATOR;
        $menuFile     = $fullAdminDir.'menu.xml';

        // including std file
        if (file_exists($menuFile)) {
            $filesToLoad[] = $menuFile;
        }

        // including custom file
        if (file_exists($fullAdminDir.'user.xml')) {
            $filesToLoad[] = $fullAdminDir.'user.xml';
        }

        $adminTheme   = $config->getShopConfVar('sAdminCustomTheme');
        $fullAdminDir = $viewsPath.$adminTheme.DIRECTORY_SEPARATOR;
        $menuFile     = $fullAdminDir.'menu.xml';

        // including std file
        if (file_exists($menuFile)) {
            $filesToLoad[] = $menuFile;
        }

        // including custom file
        if (file_exists($fullAdminDir.'user.xml')) {
            $filesToLoad[] = $fullAdminDir.'user.xml';
        }

        // including module menu files
        $path             = getShopBasePath();
        $moduleList       = oxNew(ModuleList::class);
        $activeModuleInfo = $moduleList->getActiveModuleInfo();
        if (is_array($activeModuleInfo)) {
            foreach ($activeModuleInfo as $modulePath) {
                $fullPath = $path."modules/".$modulePath;
                // missing file/folder?
                if (is_dir($fullPath)) {
                    // including menu file
                    $menuFile = $fullPath."/menu.xml";
                    if (file_exists($menuFile) && is_readable($menuFile)) {
                        $filesToLoad[] = $menuFile;
                    }
                }
            }
        }

        $parentFilesToLoad = parent::_getMenuFiles();
        $filesToLoad       = array_merge($filesToLoad, $parentFilesToLoad);

        return $filesToLoad;
    }
}
