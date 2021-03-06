<?php


namespace Wsrt\Local;

if (empty($_SERVER['DOCUMENT_ROOT'])) {
	$docr=implode('\\',array_slice(explode('\\',__FILE__),0,4));	
    $docr="U:/strc.lc";
	$_SERVER["DOCUMENT_ROOT"] = $docr;//'d:/webserver/domains/ltfdev.net';
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
                        };

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class LocmainTable extends DataManager
{
    public static function getTableName()
    {
        return 'it run not table';
    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true,
                'title' => Loc::getMessage('BEX_D7DULL_ID'),
            )),
            new StringField('NAME', array(
                'required' => true,
                'title' => Loc::getMessage('BEX_D7DULL_NAME'),
                'default_value' => function () {
                    return Loc::getMessage('BEX_D7DULL_NAME_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                },
            )),
            new StringField('IMAGE_SET', array(
                'required' => false,
                'title' => Loc::getMessage('BEX_D7DULL_IMAGE_SET'),
                'fetch_data_modification' => function () {
                    return array(
                        function ($value) {
                            if (strlen($value)) {
                                return explode(',', $value);
                            }
                        },
                    );
                },
                'save_data_modification' => function () {
                    return array(
                        function ($value) {
                            if (is_array($value)) {
                                $value = array_filter($value, 'intval');

                                return implode(',', $value);
                            }
                        },
                    );
                },
            )),
        );
    }
}

class PhpSpreadsheet //extends CModule
{
    public static function getTableName()
    {
        return 'd7dull_example';
    }

}
// $�ft = new LocmainTable();
// $ret = $�ft->getTableName();
// print_r($ret);