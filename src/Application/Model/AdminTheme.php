<?php

namespace KHVT\AdminThemeManager\Application\Model;

use OxidEsales\Eshop\Core\Registry;

/**
 * Class AdminTheme
 *
 * @package KHVT\AdminThemeManager\Model
 */
class AdminTheme extends \OxidEsales\Eshop\Core\Theme
{
    const oxAdminStandardTheme = 'admin';

    /**
     * Set theme as active
     *
     * @throws \OxidEsales\Eshop\Core\Exception\StandardException
     */
    public function activate()
    {
        $sError = $this->checkForActivationErrors();
        if ($sError) {
            /** @var \OxidEsales\Eshop\Core\Exception\StandardException $oException */
            $oException = oxNew(\OxidEsales\Eshop\Core\Exception\StandardException::class, $sError);
            throw $oException;
        }
        $sParent = $this->getInfo('parentTheme');
        if ($sParent) {
            $this->getConfig()->saveShopConfVar("str", 'sAdminTheme', $sParent);
            $this->getConfig()->saveShopConfVar("str", 'sAdminCustomTheme', $this->getId());
        } else {
            $this->getConfig()->saveShopConfVar("str", 'sAdminTheme', $this->getId());
            $this->getConfig()->saveShopConfVar("str", 'sAdminCustomTheme', '');
        }

        /** @var \OxidEsales\Eshop\Core\SettingsHandler::class $settingsHandler */
        $settingsHandler = Registry::get(\OxidEsales\Eshop\Core\SettingsHandler::class);
        $settingsHandler->setModuleType('theme')->run($this);
    }

    /**
     * Get active themes list.
     * Examples:
     *      if flow theme is active we will get ['flow']
     *      if azure is extended by some other we will get ['azure', 'extending_theme']
     *
     * @return array
     */
    public function getActiveThemesList()
    {
        $activeThemeList = [];
        if (false == $this->isAdmin()) {
            return $activeThemeList;
        }

        $adminTheme = $this->getConfig()->getConfigParam('sAdminTheme');
        if ($adminTheme) {
            $activeThemeList[] = $adminTheme;
        }

        $adminCustomTheme = $this->getConfig()->getConfigParam('sAdminCustomTheme');
        if ($adminCustomTheme) {
            $activeThemeList[] = $adminCustomTheme;
        }

        if (empty($activeThemeList)) {
            $activeThemeList[] = self::oxAdminStandardTheme;
        }

        return $activeThemeList;
    }

    /**
     * Return current active theme, or custom theme if specified
     *
     * @return string
     */
    public function getActiveThemeId()
    {
        $adminCustomTheme = $this->getConfig()->getConfigParam('sAdminCustomTheme');
        if ($adminCustomTheme) {
            return $adminCustomTheme;
        }

        $adminTheme = $this->getConfig()->getConfigParam('sAdminTheme');
        if ($adminTheme) {
            return $adminTheme;
        }

        return self::oxAdminStandardTheme;
    }

    /**
     * Load theme info list
     *
     * @return array
     */
    public function getList()
    {
        $this->_aThemeList = [];
        $sOutDir           = $this->getConfig()->getViewsDir();
        foreach (glob($sOutDir."*", GLOB_ONLYDIR) as $sDir) {
            /** @var self $adminTheme */
            $adminTheme = oxNew(self::class);
            $directoryName = basename($sDir);

            if ($adminTheme->load($directoryName)) {
                $this->_aThemeList[$sDir] = $adminTheme;
            } elseif ($directoryName === self::oxAdminStandardTheme && $adminTheme->loadOxAdmin()) {
                $this->_aThemeList[$sDir] = $adminTheme;
            }
        }

        return $this->_aThemeList;
    }

    /**
     * Load oxid standard admin theme info
     *
     * @return bool
     */
    public function loadOxAdmin()
    {
        $aTheme = [
            'id'          => self::oxAdminStandardTheme,
            'active'      => ($this->getActiveThemeId() == self::oxAdminStandardTheme),
            'title'       => 'Oxid Standard Admin',
            'description' => 'This is OXID`s official admin theme.',
            'thumbnail'   => 'theme.jpg',
            'version'     => '',
            'author'      => '<a href="http://www.oxid-esales.com" title="OXID eSales AG">OXID eSales AG</a>',
            'settings'    => array(),
        ];

        $this->_aTheme = $aTheme;

        return true;
    }

    /**
     * Load theme info
     *
     * @param string $sOXID theme id
     *
     * @return bool
     */
    public function load($sOXID)
    {
        $sFilePath = $this->getConfig()->getViewsDir() . $sOXID . "/adminTheme.php";
        if (file_exists($sFilePath) && is_readable($sFilePath)) {
            $aTheme = [];
            include $sFilePath;
            $this->_aTheme = $aTheme;
            $this->_aTheme['id'] = $sOXID;
            $this->_aTheme['active'] = ($this->getActiveThemeId() == $sOXID);

            return true;
        }

        return false;
    }
}
