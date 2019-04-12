<?php

namespace KHVT\AdminThemeManager\Application\Controller\Admin;

use KHVT\AdminThemeManager\Application\Model\AdminTheme;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;

class Base extends AdminController
{
    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_base.tpl";

    /**
     * @return string
     */
    public function render()
    {
        $return = parent::render();

        $this->addTplParam('oxid', $this->getAdminTheme()->getActiveThemeId());

        return $return;
    }

    /**
     * @return AdminTheme
     */
    public function getAdminTheme()
    {
        return oxNew(AdminTheme::class);
    }
}
