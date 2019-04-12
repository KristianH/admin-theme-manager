[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<script type="text/javascript">
    window.onload = function () {
        top.reloadEditFrame();
        [{if $updatelist == 1}]
        top.oxid.admin.updateList('[{$oxid}]');
        [{/if}]
    }
</script>

<div id="liste">
    <form name="search" id="search" action="[{$oViewConf->getSelfLink()}]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassname()}]">
        <input type="hidden" name="lstrt" value="[{$lstrt}]">
        <input type="hidden" name="sort" value="[{$sort}]">
        <input type="hidden" name="actedit" value="[{$actedit}]">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="language" value="[{$actlang}]">
        <input type="hidden" name="editlanguage" value="[{$actlang}]">

        <table width="100%">
            <colgroup>
                [{block name="khvt_adminthememanager_application_controller_admin_adminlist_colgroup"}]
                    <col width="3%">
                    <col width="98%">
                [{/block}]
            </colgroup>
            <tr class="listitem">
                [{block name="khvt_adminthememanager_application_controller_admin_adminlist_filter"}]
                    <td valign="top" class="listfilter first" height="20">
                        <div class="r1">
                            <div class="b1">&nbsp;</div>
                        </div>
                    </td>
                    <td valign="top" class="listfilter" height="20">
                        <div class="r1">
                            <div class="b1">&nbsp;</div>
                        </div>
                    </td>
                [{/block}]
            </tr>
            <tr>
                [{block name="khvt_adminthememanager_application_controller_admin_adminlist_sorting"}]
                    <td class="listheader first" height="15">
                        <b><a href="Javascript:document.search.sort.value='oxtitle';document.search.submit();"
                              class="listheader">[{oxmultilang ident="GENERAL_ACTIVE"}]</a></b>
                    </td>
                    <td class="listheader" height="15">
                        <b><a href="Javascript:document.search.sort.value='oxtitle';document.search.submit();"
                              class="listheader">[{oxmultilang ident="GENERAL_NAME"}]</a></b>
                    </td>
                [{/block}]
            </tr>
            [{foreach from=$adminThemeList item="adminTheme"}]
                <tr id="row.[{counter}]">
                    [{block name="khvt_adminthememanager_application_controller_admin_adminlist_item"}]
                        [{cycle values="listitem,listitem2" assign="cssClass"}]
                        [{if $selectedAdminThemeId == $adminTheme->getInfo('id')}]
                            [{assign var="cssClass" value="listitem4"}]
                        [{/if}]
                        <td valign="top"
                            class="[{$cssClass}][{if $adminTheme->getInfo('active')}] active[{/if}]"
                            height="15">
                            <div class="listitemfloating">
                                <a href="Javascript:top.oxid.admin.editThis('[{$adminTheme->getInfo('id')}]');">&nbsp;</a>
                            </div>
                        </td>
                        <td valign="top" class="[{$cssClass}]" height="15">
                            <div class="listitemfloating">
                                <a href="Javascript:top.oxid.admin.editThis('[{$adminTheme->getInfo('id')}]');">[{$adminTheme->getInfo('title')}]</a>
                            </div>
                        </td>
                    [{/block}]
                </tr>
            [{/foreach}]
            [{include file="pagenavisnippet.tpl" colspan="5"}]
        </table>
    </form>
</div>

[{include file="pagetabsnippet.tpl"}]

<script type="text/javascript">
    if (parent.parent) {
        parent.parent.sShopTitle = "[{$actshopobj->oxshops__oxname->getRawValue()|oxaddslashes}]";
        parent.parent.sMenuItem = "[{oxmultilang ident="mxextensions"}]";
        parent.parent.sMenuSubItem = "[{oxmultilang ident="khvt_adminthememanager_application_controller_admin_base"}]";
        parent.parent.sWorkArea = "[{$_act}]";
        parent.parent.setTitle();
    }
</script>
</body>
</html>

