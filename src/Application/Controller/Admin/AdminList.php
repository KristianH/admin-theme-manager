<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;

class AdminList extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_adminlist.tpl";

    /**
     * @return string
     */
    public function render()
    {
        $return = parent::render();

        $this->addTplParam('adminThemeList', $this->getAdminThemeList());

        return $return;
    }

    public function getAdminThemeList()
    {
        $adminTheme = $this->getAdminTheme();

        return $adminTheme->getList();
    }

    /**
     * @return AdminTheme
     */
    public function getAdminTheme()
    {
        return oxNew(AdminTheme::class);
    }
}
