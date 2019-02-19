<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;


class NavigationTree extends NavigationTree_parent
{
    /**
     * Returns array witn pathes + names ox manu xml files. Paths are checked
     *
     * @return array
     */
    protected function _getMenuFiles()
    {
        $filesToLoad = [];
        /** @var \KHVT\AdminThemeManager\Core\Config $config */
        $config     = $this->getConfig();
        $viewsPath  = $config->getViewsDir(true);
        $adminTheme = $config->getAdminThemeManagerSelectedTheme();

        $fullAdminDir = $viewsPath . $adminTheme . DIRECTORY_SEPARATOR;
        $menuFile = $fullAdminDir . 'menu.xml';

        // including std file
        if (file_exists($menuFile)) {
            $filesToLoad[] = $menuFile;
        }

        // including custom file
        if (file_exists($fullAdminDir . 'user.xml')) {
            $filesToLoad[] = $fullAdminDir . 'user.xml';
        }

        // including module menu files
        $path = getShopBasePath();
        $modulelist = oxNew(\OxidEsales\Eshop\Core\Module\ModuleList::class);
        $activeModuleInfo = $modulelist->getActiveModuleInfo();
        if (is_array($activeModuleInfo)) {
            foreach ($activeModuleInfo as $modulePath) {
                $fullPath = $path . "modules/" . $modulePath;
                // missing file/folder?
                if (is_dir($fullPath)) {
                    // including menu file
                    $menuFile = $fullPath . "/menu.xml";
                    if (file_exists($menuFile) && is_readable($menuFile)) {
                        $filesToLoad[] = $menuFile;
                    }
                }
            }
        }

        $parentFilesToLoad = parent::_getMenuFiles();
        $filesToLoad = array_merge($filesToLoad, $parentFilesToLoad);

        return $filesToLoad;
    }
}
