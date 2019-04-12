<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Application\Controller\Admin\ShopConfiguration;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;

class Settings extends ShopConfiguration
{

    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_settings.tpl";

    protected $currentAdminThemeID;

    /**
     * @return string
     */
    public function render()
    {
        $return                    = parent::render();
        $adminTheme                = $this->getLoadedAdminTheme();
        $this->currentAdminThemeID = $adminTheme->getId();
        $this->addTplParam('currentAdminTheme', $adminTheme);
        $this->addTplParam('oxid', $this->currentAdminThemeID);
        $this->addTplParam('sHelpURL', "");

        try {
            $aDbVariables = $this->loadConfVars($this->getConfig()->getShopId(), $this->_getModuleForConfigVars());
            $this->addTplParam("var_constraints", $aDbVariables['constraints']);
            $this->addTplParam("var_grouping", $aDbVariables['grouping']);
            foreach ($this->_aConfParams as $sType => $sParam) {
                $this->addTplParam($sParam, $aDbVariables['vars'][$sType]);
            }
        } catch (StandardException $oEx) {
            Registry::getUtilsView()->addErrorToDisplay($oEx);
            Registry::getLogger()->error(
                $oEx->getMessage(),
                [$oEx]
            );
        }

        return $return;
    }

    /**
     * return theme filter for config variables
     *
     * @return string
     */
    protected function _getModuleForConfigVars()
    {
        if ($this->currentAdminThemeID === null) {
            $this->currentAdminThemeID = $this->getEditObjectId();
        }

        return Config::OXMODULE_THEME_PREFIX.$this->currentAdminThemeID;
    }

    /**
     * Saves shop configuration variables
     */
    public function saveConfVars()
    {
        $myConfig = $this->getConfig();
        $request = Registry::getRequest();
        AdminController::save();

        $sShopId = $myConfig->getShopId();

        $sModule = $this->_getModuleForConfigVars();

        foreach ($this->_aConfParams as $sType => $sParam) {
            $aConfVars = $request->getRequestParameter($sParam);
            if (is_array($aConfVars)) {
                foreach ($aConfVars as $sName => $sValue) {
                    $myConfig->saveShopConfVar(
                        $sType,
                        $sName,
                        $this->_serializeConfVar($sType, $sName, $sValue),
                        $sShopId,
                        $sModule
                    );
                }
            }
        }
    }

    /**
     * @return AdminTheme
     */
    protected function getLoadedAdminTheme()
    {
        /** @var AdminTheme $adminTheme */
        $adminTheme          = oxNew(AdminTheme::class);
        $currentAdminThemeId = $this->getEditObjectId();

        if (false == $adminTheme->load($currentAdminThemeId)) {
            $message = Registry::getLang()->translateString('KHVT_EXCEPTION_ADMINTHEME_NOT_LOADED');
            $message .= Registry::getLang()->translateString('COLON');
            $message .= " $currentAdminThemeId";
            Registry::getUtilsView()->addErrorToDisplay(
                oxNew(StandardException::class, $message)
            );
        }

        return $adminTheme;
    }
}
