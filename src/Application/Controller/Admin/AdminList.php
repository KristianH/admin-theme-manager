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
        $return        = parent::render();
        $editid = $this->getEditObjectId();

        $this->addTplParam('adminThemeList', $this->getAdminThemeList());
        $this->addTplParam('oxid', $editid);
        if (empty($editid)) {
            $this->setEditObjectId($editid);
            $this->addTplParam("updatelist", 0);
        }
        $this->addTplParam('selectedAdminThemeId', $editid);

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
