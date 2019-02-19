<?php
namespace KHVT\AdminThemeManager\Application\Controller\Admin;

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

        $this->addTplParam('sHelpURL', "");

        return $return;
    }
}
