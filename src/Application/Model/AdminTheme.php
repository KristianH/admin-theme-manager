<?php
namespace KHVT\AdminThemeManager\Model;

/**
 * Class AdminTheme
 *
 * @package KHVT\AdminThemeManager\Model
 */
class AdminTheme extends \OxidEsales\Eshop\Core\Theme
{

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
            $this->getConfig()->saveShopConfVar("str", 'sTheme', $sParent);
            $this->getConfig()->saveShopConfVar("str", 'sCustomTheme', $this->getId());
        } else {
            $this->getConfig()->saveShopConfVar("str", 'sTheme', $this->getId());
            $this->getConfig()->saveShopConfVar("str", 'sCustomTheme', '');
        }
        $settingsHandler = oxNew(\OxidEsales\Eshop\Core\SettingsHandler::class);
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
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();

        $activeThemeList = [];
        if ($this->isAdmin()) {
            $activeThemeList[] = $config->getConfigParam('sTheme');

            if ($customThemeId = $config->getConfigParam('sCustomTheme')) {
                $activeThemeList[] = $customThemeId;
            }
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
        $sCustTheme = $this->getConfig()->getConfigParam('sCustomTheme');
        if ($sCustTheme) {
            return $sCustTheme;
        }

        return $this->getConfig()->getConfigParam('sTheme');
    }
}
