[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="box"}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$currentAdminTheme->getInfo('id')}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassname()}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{block name="khvt_adminthememanager_application_controller_admin_main_form"}]
    <table width="98%">
        [{if $activationMessage}]
            <tr>
                <td colspan="2">
                    <div class="messagebox">
                        <p class="warning">[{oxmultilang ident=$activationMessage}]</p>
                    </div>
                </td>
                <td></td>
            </tr>
        [{/if}]
        <tr>
            <td width="30%" valign="top">
                <img src="[{$currentAdminTheme->getThumbnailUrl()}]"
                     style="max-width: 100%;"
                     alt="[{oxmultilang ident="KHVT_ATM_THEME_MISSING_THUMBNAIL"}]">
            </td>
            <td valign="top">
                <h1>[{$currentAdminTheme->getInfo('title')}]</h1>
                <p>[{$currentAdminTheme->getInfo('description')}]</p>
                [{if $currentAdminTheme->getInfo('parentTheme')}]
                    <strong>[{oxmultilang ident="THEME_PARENT_THEME_TITLE"}]: </strong>
                    [{assign var='parentAdminTheme' value=$currentAdminTheme->getParent()}]
                    [{if $parentAdminTheme}]
                        <a class="themetitle"
                           href="[{$oViewConf->getSelfLink()}]&amp;cl=[{$oViewConf->getActiveClassname()}]&amp;oxid=[{$currentAdminTheme->getInfo('parentTheme')}]&amp;updatelist=1">[{$parentAdminTheme->getInfo('title')}]</a>
                    [{else}]
                        <span class="error">[{$currentAdminTheme->getInfo('parentTheme')}]</span>
                    [{/if}]
                    <br>
                    <strong>[{oxmultilang ident="THEME_PARENT_VERSIONS"}]: </strong>
                    [{', '|implode:$currentAdminTheme->getInfo('parentVersions')}]
                [{/if}]
                <hr>
                <p style="color:#aaa;">
                    <b>[{oxmultilang ident="KHVT_ATM_THEME_AUTHOR"}]</b> [{$currentAdminTheme->getInfo('author')}]
                    <br><br>
                    [{oxmultilang ident="KHVT_ATM_THEME_VERSION"}] [{$currentAdminTheme->getInfo('version')}]
                </p>
            </td>
            <td width="20%" valign="top">
                [{assign var='disabledActivateButton' value=''}]
                [{if $currentAdminTheme->getInfo('active')}]
                    [{assign var='disabledActivateButton' value=' disabled="disabled"'}]
                [{/if}]

                <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
                    <p>
                        [{$oViewConf->getHiddenSid()}]
                        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
                        <input type="hidden" name="fnc" value="setAdminTheme">
                        <input type="hidden" name="updatelist" value="1">
                        <input type="hidden" name="oxid" value="[{$currentAdminTheme->getInfo('id')}]">
                        <input type="submit"
                               class="btn"
                               value="[{oxmultilang ident="KHVT_ATM_THEME_ACTIVATE"}]"
                            [{$disabledActivateButton}]>
                        [{oxinputhelp ident="KHVT_ATM_THEME_ACTIVATE_HELP"}]
                    </p>
                </form>
                [{assign var='activationError' value=$currentAdminTheme->checkForActivationErrors()}]
                [{if $activationError}]
                    <div class="error">[{oxmultilang ident=$activationError}]</div>
                [{/if}]
                <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
                    <p>
                        [{$oViewConf->getHiddenSid()}]
                        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
                        <input type="hidden" name="fnc" value="resetCache">
                        <input type="hidden" name="updatelist" value="1">
                        <input type="hidden" name="oxid" value="[{$currentAdminTheme->getInfo('id')}]">
                        <input type="submit" class="btn" value="[{oxmultilang ident="KHVT_ATM_THEME_RESET_CACHE"}]">
                        [{oxinputhelp ident="KHVT_ATM_THEME_RESET_CACHE_HELP"}]
                    </p>
                </form>
            </td>
        </tr>
    </table>
[{/block}]

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
