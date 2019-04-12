<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Module\ModuleVariablesLocator;
use OxidEsales\Eshop\Core\Registry;

class Main extends AdminDetailsController
{

    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_main.tpl";

    /**
     * @return string
     */
    public function render()
    {
        $return       = parent::render();
        $adminTheme   = $this->getLoadedAdminTheme();
        $adminThemeId = $adminTheme->getId();
        $this->addTplParam('currentAdminTheme', $adminTheme);
        $this->addTplParam('oxid', $adminThemeId);

        $this->addTplParam('sHelpURL', "");

        return $return;
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

    /**
     * @throws StandardException
     */
    public function setAdminTheme()
    {
        $this->getLoadedAdminTheme()->activate();
        $this->resetCache();
        $this->addTplParam('activationMessage', 'KHVT_ATM_ADMIN_RELOGIN');
    }

    /**
     * Resets template, language and menu xml cache
     */
    public function resetCache()
    {
        $templates = $this->getLoadedAdminTheme()->getTemplates();

        $utils = Registry::getUtils();
        $utils->resetTemplateCache($templates);
        $utils->resetLanguageCache();
        $utils->resetMenuCache();

        ModuleVariablesLocator::resetModuleVariables();

        $this->_clearApcCache();
    }

    /**
     * Cleans PHP APC cache
     */
    protected function _clearApcCache()
    {
        if (extension_loaded('apc') && ini_get('apc.enabled')) {
            apc_clear_cache();
        }
    }
}
