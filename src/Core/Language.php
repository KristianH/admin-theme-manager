<?php

namespace KHVT\AdminThemeManager\Core;

use OxidEsales\Eshop\Core\Registry;

/**
 * Class Language
 *
 * @package KHVT\AdminThemeManager\Core
 */
class Language extends Language_parent
{
    /**
     * @param int $iLang
     *
     * @return array|bool
     */
    protected function _getAdminLangFilesPathArray($iLang)
    {
        $oConfig    = $this->getConfig();
        $aLangFiles = [];
        $sTheme     = $oConfig->getConfigParam("sAdminTheme");
        $sAppDir    = $oConfig->getAppDir();
        $sLang      = Registry::getLang()->getLanguageAbbr($iLang);

        $aModulePaths = [];
        $aModulePaths = array_merge($aModulePaths, $this->_getActiveModuleInfo());
        $aModulePaths = array_merge($aModulePaths, $this->_getDisabledModuleInfo());

        // admin lang files
        $sAdminPath   = $sAppDir.'views/'.$sTheme.'/'.$sLang;
        $aLangFiles[] = $sAdminPath."/lang.php";
        $aLangFiles[] = $sAppDir.'translations/'.$sLang.'/translit_lang.php';
        $aLangFiles   = $this->_appendLangFile($aLangFiles, $sAdminPath);

        $aLangFiles = array_merge($aLangFiles, $this->getAdminCustomThemeLanguageFiles($iLang));

        // themes options lang files
        $sThemePath = $sAppDir.'views/*/'.$sLang;
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
            $sTheme       = $oConfig->getConfigParam("sAdminTheme");
            $sCustomTheme = $oConfig->getConfigParam("sAdminCustomTheme");

            if ($sTheme) {
                $aLangFiles[] = $sAppDir.'views/'.$sTheme.'/'.$sLang.'/cust_lang.php';
            }

            if ($sCustomTheme) {
                $aLangFiles[] = $sAppDir.'views/'.$sCustomTheme.'/'.$sLang.'/cust_lang.php';
            }

            return $aLangFiles;
        }

        return parent::_appendCustomLangFiles($aLangFiles, $sLang, $blForAdmin);
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
            $sTheme   = $myConfig->getConfigParam("sAdminTheme");

            $aLangArray                    = $this->getLanguageArray();
            $this->_aAdminTplLanguageArray = [];

            $sSourceDir = $myConfig->getAppDir().'views/'.$sTheme.'/';
            foreach ($aLangArray as $iLangKey => $oLang) {
                $sFilePath = "{$sSourceDir}{$oLang->abbr}/lang.php";
                if (file_exists($sFilePath) && is_readable($sFilePath)) {
                    $this->_aAdminTplLanguageArray[$iLangKey] = $oLang;
                }
            }

            $sCustomTheme = $myConfig->getConfigParam("sAdminCustomTheme");
            if ($sCustomTheme) {
                $sSourceDir = $myConfig->getAppDir().'views/'.$sCustomTheme.'/';
                foreach ($aLangArray as $iLangKey => $oLang) {
                    $sFilePath = "{$sSourceDir}{$oLang->abbr}/lang.php";
                    if (file_exists($sFilePath) && is_readable($sFilePath)) {
                        $this->_aAdminTplLanguageArray[$iLangKey] = $oLang;
                    }
                }
            }
        }

        // moving pointer to beginning
        reset($this->_aAdminTplLanguageArray);

        return $this->_aAdminTplLanguageArray;
    }

    /**
     * @param int  $iLang
     * @param null $blAdmin
     *
     * @return array
     */
    protected function _getLanguageMap($iLang, $blAdmin = null)
    {
        $blAdmin = isset($blAdmin) ? $blAdmin : $this->isAdmin();
        $sKey    = $iLang.((int)$blAdmin);
        if (!isset($this->_aLangMap[$sKey])) {
            $this->_aLangMap[$sKey] = [];
            /** @var Config $myConfig */
            $myConfig   = $this->getConfig();
            $adminTheme = $myConfig->getAdminThemeManagerSelectedTheme();

            $sMapFile            = '';
            $sParentMapFile      = $myConfig->getAppDir().'/views/'
                .($blAdmin ? $adminTheme : $myConfig->getConfigParam("sTheme"))
                .'/'
                .Registry::getLang()->getLanguageAbbr($iLang).'/map.php';
            $sCustomThemeMapFile = $myConfig->getAppDir().'/views/'
                .($blAdmin ? $adminTheme : $myConfig->getConfigParam("sCustomTheme"))
                .'/'
                .Registry::getLang()->getLanguageAbbr($iLang).'/map.php';

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

    /**
     * Returns custom theme language files.
     *
     * @param int $language active language
     *
     * @return array
     */
    protected function getAdminCustomThemeLanguageFiles($language)
    {
        $oConfig      = $this->getConfig();
        $sCustomTheme = $oConfig->getConfigParam("sAdminCustomTheme");
        $sAppDir      = $oConfig->getAppDir();
        $sLang        = Registry::getLang()->getLanguageAbbr($language);
        $aLangFiles   = [];

        if ($sCustomTheme) {
            $sCustPath    = $sAppDir.'views/'.$sCustomTheme.'/'.$sLang;
            $aLangFiles[] = $sCustPath."/lang.php";
            $aLangFiles   = $this->_appendLangFile($aLangFiles, $sCustPath);
        }

        return $aLangFiles;
    }
}
