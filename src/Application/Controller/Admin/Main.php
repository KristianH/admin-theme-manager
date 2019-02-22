<?php
namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
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
        $return = parent::render();

        $this->addTplParam('currentAdminTheme', $this->getLoadedAdminTheme());

        $this->addTplParam('sHelpURL', "");

        return $return;
    }

    protected function getLoadedAdminTheme()
    {
        /** @var AdminTheme $adminTheme */
        $adminTheme =  oxNew(AdminTheme::class);
        $currentAdminThemeId = $this->getEditObjectId();
        if (empty($currentAdminThemeId)) {
            $currentAdminThemeId = $adminTheme->getActiveThemeId();
            $this->setEditObjectId($currentAdminThemeId);
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

    public function setAdminTheme()
    {

    }
}
