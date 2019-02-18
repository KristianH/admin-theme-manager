<?php
/**
 * Created by PhpStorm.
 * User: KristianHempel
 * Date: 18.02.2019
 * Time: 09:05
 */

namespace KHVT\AdminThemeManager\Core;

class Language extends Language_parent
{
    protected function _getAdminLangFilesPathArray($iLang)
    {
        $oConfig = $this->getConfig();
        $aLangFiles = [];
        $sTheme = $this->getAdminThemeManagerSelectedTheme();
        $sAppDir = $oConfig->getAppDir();
        $sLang = \OxidEsales\Eshop\Core\Registry::getLang()->getLanguageAbbr($iLang);

        $aModulePaths = [];
        $aModulePaths = array_merge($aModulePaths, $this->_getActiveModuleInfo());
        $aModulePaths = array_merge($aModulePaths, $this->_getDisabledModuleInfo());

        // admin lang files
        $sAdminPath = $sAppDir . 'views/'. $sTheme .'/' . $sLang;
        $aLangFiles[] = $sAdminPath . "/lang.php";
        $aLangFiles[] = $sAppDir . 'translations/' . $sLang . '/translit_lang.php';
        $aLangFiles = $this->_appendLangFile($aLangFiles, $sAdminPath);

        // themes options lang files
        $sThemePath = $sAppDir . 'views/*/' . $sLang;
        $aLangFiles = $this->_appendLangFile($aLangFiles, $sThemePath, "options");

        // module language files
        $aLangFiles = $this->_appendModuleLangFiles($aLangFiles, $aModulePaths, $sLang, true);

        // custom language files
        $aLangFiles = $this->_appendCustomLangFiles($aLangFiles, $sLang, true);

        return count($aLangFiles) ? $aLangFiles : false;
    }

    /**
     * Appends Custom language files cust_lang.php
     *
     * @param array  $aLangFiles existing language files
     * @param string $sLang      language abbreviation
     * @param bool   $blForAdmin add files for admin
     *
     * @return array
     */
    protected function _appendCustomLangFiles($aLangFiles, $sLang, $blForAdmin = false)
    {
        if ($blForAdmin) {
            /** @var Config $oConfig */
            $oConfig      = $this->getConfig();
            $sAppDir      = $oConfig->getAppDir();
            $sTheme       = $this->getAdminThemeManagerSelectedTheme();

            $aLangFiles[] = $sAppDir.'views/'.$sTheme.'/'.$sLang.'/cust_lang.php';

            return $aLangFiles;
        }


        return parent::_appendCustomLangFiles($aLangFiles, $sLang, $blForAdmin);
    }

    public function getAdminThemeManagerSelectedTheme()
    {
        /** @var Config $oConfig */
        $oConfig      = $this->getConfig();
        return $oConfig->getAdminThemeManagerSelectedTheme();
    }
}
