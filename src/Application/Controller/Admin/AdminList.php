<?php
namespace KHVT\AdminThemeManager\Application\Controller\Admin;

class AdminList extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_adminlist.tpl";
    /**
     *
     * @return string
     */
    public function render()
    {
        $return = parent::render();

        return $return;
    }
}
