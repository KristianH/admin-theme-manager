<?php
namespace KHVT\AdminThemeManager\Application\Controller\Admin;

class Base extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    protected $_sThisTemplate = "khvt_adminthememanager_application_views_admin_tpl_base.tpl";
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
