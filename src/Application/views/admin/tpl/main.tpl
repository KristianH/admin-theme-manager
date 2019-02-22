[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="box"}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassname()}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{block name="khvt_adminthememanager_application_controller_admin_main_form"}]
    <table cellspacing="10" width="98%">
        <tr>
            <td width="30%" valign="top">
                <img src="[{$currentAdminTheme->getThumbnailUrl()}]" style="max-width: 100%;" alt="missing theme thumbnail">
            </td>
            <td valign="top">
                <h1>[{$currentAdminTheme->getInfo('title')}]</h1>
                <p>[{$currentAdminTheme->getInfo('description')}]</p>
                <hr>
                <p style="color:#aaa;">
                    <b>[{oxmultilang ident="THEME_AUTHOR"}]</b> [{$currentAdminTheme->getInfo('author')}]<br><br>
                    [{oxmultilang ident="THEME_VERSION"}] [{$currentAdminTheme->getInfo('version')}]
                </p>
            </td>
            <td width="20%" valign="top">
                [{if false == $currentAdminTheme->getInfo('active')}]
                    [{assign var='activationError' value=$currentAdminTheme->checkForActivationErrors()}]
                    [{if false == $activationError}]
                        <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
                            <p>
                                [{$oViewConf->getHiddenSid()}]
                                <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
                                <input type="hidden" name="fnc" value="setAdminTheme">
                                <input type="hidden" name="updatelist" value="1">
                                <input type="hidden" name="oxid" value="[{$currentAdminTheme->getInfo('id')}]">
                                <input type="submit" value="[{oxmultilang ident="THEME_ACTIVATE"}]">
                            </p>
                        </form>
                    [{else}]
                        <div class="error">[{oxmultilang ident=$activationError}]</div>
                    [{/if}]
                [{/if}]
            </td>
        </tr>
    </table>
[{/block}]

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
