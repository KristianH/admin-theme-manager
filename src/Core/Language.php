<?php

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

    /**
     * Returns languages array containing possible admin template translations
     *
     * @return array
     */
    public function getAdminTplLanguageArray()
    {
        if ($this->_aAdminTplLanguageArray === null) {
            $myConfig = $this->getConfig();
            $sTheme   = $this->getAdminThemeManagerSelectedTheme();

            $aLangArray = $this->getLanguageArray();
            $this->_aAdminTplLanguageArray = [];

            $sSourceDir = $myConfig->getAppDir() . 'views/' . $sTheme . '/';
            foreach ($aLangArray as $iLangKey => $oLang) {
                $sFilePath = "{$sSourceDir}{$oLang->abbr}/lang.php";
                if (file_exists($sFilePath) && is_readable($sFilePath)) {
                    $this->_aAdminTplLanguageArray[$iLangKey] = $oLang;
                }
            }
        }

        // moving pointer to beginning
        reset($this->_aAdminTplLanguageArray);

        return $this->_aAdminTplLanguageArray;
    }

    protected function _getLanguageMap($iLang, $blAdmin = null)
    {
        $blAdmin = isset($blAdmin) ? $blAdmin : $this->isAdmin();
        $sKey = $iLang . ((int) $blAdmin);
        if (!isset($this->_aLangMap[$sKey])) {
            $this->_aLangMap[$sKey] = [];
            /** @var Config $myConfig */
            $myConfig = $this->getConfig();
            $adminTheme = $myConfig->getAdminThemeManagerSelectedTheme();

            $sMapFile = '';
            $sParentMapFile = $myConfig->getAppDir() . '/views/' . ($blAdmin ? $adminTheme : $myConfig->getConfigParam("sTheme")) . '/' . \OxidEsales\Eshop\Core\Registry::getLang()->getLanguageAbbr($iLang) . '/map.php';
            $sCustomThemeMapFile = $myConfig->getAppDir() . '/views/' . ($blAdmin ? $adminTheme : $myConfig->getConfigParam("sCustomTheme")) . '/' . \OxidEsales\Eshop\Core\Registry::getLang()->getLanguageAbbr($iLang) . '/map.php';

            if (file_exists($sCustomThemeMapFile) && is_readable($sCustomThemeMapFile)) {
                $sMapFile = $sCustomThemeMapFile;
            } elseif (file_exists($sParentMapFile) && is_readable($sParentMapFile)) {
                $sMapFile = $sParentMapFile;
            }

            if ($sMapFile) {
                $aMap = [];
                include $sMapFile;
                $this->_aLangMap[$sKey] = $aMap;
            }
        }

        return $this->_aLangMap[$sKey];
    }
}
