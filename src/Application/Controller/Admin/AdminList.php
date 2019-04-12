<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Application\Controller\Admin\AdminListController;

class AdminList extends AdminListController
{
    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_adminlist.tpl";

    /**
     * @return string
     */
    public function render()
    {
        $return = parent::render();
        $editObjectId = $this->getEditObjectId();

        $this->addTplParam('adminThemeList', $this->getAdminThemeList());
        $this->addTplParam('oxid', $editObjectId);
        if (empty($editObjectId)) {
            $this->setEditObjectId($editObjectId);
            $this->addTplParam("updatelist", 0);
        }
        $this->addTplParam('selectedAdminThemeId', $editObjectId);

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
