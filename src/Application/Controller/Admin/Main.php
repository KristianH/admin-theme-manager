<?php
namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Core\Module\ModuleVariablesLocator;
use OxidEsales\Eshop\Core\Registry;

class Main extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_main.tpl";
    /**
     *
     * @return string
     */
    public function render()
    {
        $return       = parent::render();
        $adminTheme   = $this->getLoadedAdminTheme();
        $adminThemeId = $adminTheme->getActiveThemeId();
        $this->addTplParam('currentAdminTheme', $adminTheme);
        $this->addTplParam('oxid', $adminThemeId);

        $this->addTplParam('sHelpURL', "");
        //        /** @var ClassProviderStorage $classProviderStorage */
        //        $classProviderStorage = oxNew(ClassProviderStorage::class);
        //        $classStorage = $classProviderStorage ->get();
        //        dumpvar(array_flip($classStorage['admin-theme-manager']));
        return $return;
    }

    /**
     * @return AdminTheme
     */
    protected function getLoadedAdminTheme()
    {
        /** @var AdminTheme $adminTheme */
        $adminTheme =  oxNew(AdminTheme::class);
        $currentAdminThemeId = $this->getEditObjectId();
        if (empty($currentAdminThemeId)) {
            $currentAdminThemeId = $adminTheme->getActiveThemeId();
            $this->setEditObjectId($currentAdminThemeId);
            $this->addTplParam("updatelist", 0);
        }

        if(false == $adminTheme->load($currentAdminThemeId)) {
            $message = Registry::getLang()->translateString('KHVT_EXCEPTION_ADMINTHEME_NOT_LOADED');
            $message .= Registry::getLang()->translateString('COLON');
            $message .= " $currentAdminThemeId";
            Registry::getUtilsView()->addErrorToDisplay(
                oxNew(\OxidEsales\Eshop\Core\Exception\StandardException::class, $message)
            );
        }

        return $adminTheme;
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\StandardException
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
