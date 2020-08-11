<?php

if (empty($_SERVER['DOCUMENT_ROOT'])) {
	$docr=implode('\\',array_slice(explode('\\',__FILE__),0,4));	
    $docr="U:/wsrt";
	$_SERVER["DOCUMENT_ROOT"] = $docr;//'d:/webserver/domains/ltfdev.net';
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
                        };
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Local\ExampleTable;

Loc::loadMessages(__FILE__);

class WsrtLocal extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        
        $this->MODULE_ID = 'wsrt.local';
        $this->MODULE_NAME = 'wsrt main local module';
        $this->MODULE_DESCRIPTION = 'wsrt main local module for extension';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = 'wsrt';
        $this->PARTNER_URI = 'http://wsrt.localhost';
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        // $this->installDB();
    }

    public function doUninstall()
    {
        // $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            ExampleTable::getEntity()->createDbTable();
        }
    }

    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            $connection = Application::getInstance()->getConnection();
            $connection->dropTable(ExampleTable::getTableName());
        }
    }
}

// $ret=new Wsrt;