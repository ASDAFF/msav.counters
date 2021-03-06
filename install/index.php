<?php
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Msav\Module\Counters\CMsavModCountersHelper;

Loc::loadMessages(__FILE__);


class msav_counters extends CModule
{
    var $MODULE_ID = 'msav.counters';
    var $PARTNER_NAME = 'Andrey Mishchenko';
    var $PARTNER_URI = 'http://www.msav.ru';

    function __construct()
    {
        $arModuleVersion = array();
        include("version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = Loc::getMessage('MD_MSAV_COUNTERS_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MD_MSAV_COUNTERS_DESC');
        $this->PARTNER_NAME = Loc::getMessage('MD_MSAV_COUNTERS_VENDOR_NAME');
        $this->PARTNER_URI = Loc::getMessage('MD_MSAV_COUNTERS_VENDOR_URL');
    }


    function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
	    try {
		    Loader::includeModule( $this->MODULE_ID );
	    } catch ( \Bitrix\Main\LoaderException $e ) {
	    	AddMessage2Log($e->getMessage());
	    }
	    CMsavModCountersHelper::register($this->MODULE_ID);
    }

    function DoUninstall()
    {
	    try {
		    Loader::includeModule( $this->MODULE_ID );
	    } catch ( \Bitrix\Main\LoaderException $e ) {
		    AddMessage2Log($e->getMessage());
	    }
	    ModuleManager::unRegisterModule($this->MODULE_ID);
        CMsavModCountersHelper::unregister($this->MODULE_ID);
    }
}