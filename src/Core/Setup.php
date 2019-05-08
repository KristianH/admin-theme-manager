<?php

namespace KHVT\AdminThemeManager\Core;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;

/**
 * Class Setup
 *
 * @package KHVT\AdminThemeManager\Core
 */
class Setup
{
    /**
     *
     */
    public static function install()
    {
        $shopId = Registry::getConfig()->getShopId();
        try {
            $db = DatabaseProvider::getDb();
            $hasEntry = $db->getOne(
                "SELECT 1 FROM oxconfig WHERE oxvarname = \"sAdminTheme\" AND oxshopid = {$shopId}"
            );

            if(false == $hasEntry){
                $adminTheme = oxNew(AdminTheme::class);
                $adminTheme->loadOxAdmin();
                $adminTheme->saveConfiguration();
            }
        } catch (DatabaseConnectionException $e) {
            Registry::get(UtilsView::class)->addErrorToDisplay(
                new StandardException(
                    'Database error: '.$e->getMessage().PHP_EOL.$e->getTraceAsString()
                )
            );
        }

    }
}
