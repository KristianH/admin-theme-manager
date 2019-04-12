<?php
$sLangName = "Deutsch";

$aLang = array(
    'charset'                                                  => 'UTF-8',
    'khvt_adminthememanager_application_controller_admin_base' => 'Admin-Themes',
    'khvt_adminthememanager_application_controller_admin_main' => 'Stamm',
    'khvt_adminthememanager_application_controller_admin_settings' => 'Einstell.',
    'KHVT_ATM_THEME_AUTHOR'                                    => 'Autor',
    'KHVT_ATM_THEME_VERSION'                                   => 'Version',
    'KHVT_ATM_THEME_RESET_CACHE'                               => 'Cache leeren',
    'KHVT_ATM_THEME_RESET_CACHE_HELP'                          => 'Löscht die Dateien im /source/tmp/ Ordern die zum aktuellen Admin Theme gehören.',
    'KHVT_ATM_THEME_ACTIVATE'                                  => 'Aktivieren',
    'KHVT_ATM_THEME_ACTIVATE_HELP'                             => 'Aktiviert das Admin Theme und leert im Anschluss den Cache des Admin Themes.',
    'KHVT_ATM_THEME_MISSING_THUMBNAIL'                         => 'Die Information thumbnail in der adminTheme.php wurde nicht gepflegt.' //
        . '<br>Speichern Sie ein Thumbnailbild mit den Seitenverhältnis 1265x468 in das Verzeichnis unter /source/out/{themeId}/{bildname}.{endung} (bspw. /source/out/admin/thumbnail.png).'
        . '<br>Tragen Sie den Namen in die Variable der /source/Application/views/{themeid}/adminTheme.php mit dem Index  \'thumbnail\' ein.
<br>Beispiel:
<pre>
$themeParameter = [
    \'thumbnail\'   => \'theme.jpg\',
];

// oder 
$themeParameter[\'thumbnail\'] = \'theme.jpg\';
</pre>
',
    'KHVT_ATM_ADMIN_RELOGIN'                                   => 'Bitte drücken Sie F5 (Seite neu laden), damit die Änderungen komplett wirksam werden!',
    'KHVT_EXCEPTION_ADMINTHEME_NOT_LOADED'                     => 'Theme kann nicht geladen werden',
);
