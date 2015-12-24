<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
IncludeModuleLangFile(__FILE__);

$psTitle = GetMessage("RFICB.PAYMENT_TITLE");
$psDescription  = GetMessage("RFICB.PAYMENT_DESC");

$arPSCorrespondence = array(
    "ORDER_ID" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_ORDER_ID"),
        "DESCR" => GetMessage("RFICB.PAYMENT_ORDER_ID_DESC"),
        "VALUE" => "ID",
        "TYPE" => "ORDER",
    ),
    "DATE_INSERT" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_ORDER_DATE"),
        "DESCR" => GetMessage("RFICB.PAYMENT_ORDER_DATE_DESC"),
        "VALUE" => "DATE_INSERT",
        "TYPE" => "ORDER",
    ),
    "SHOULD_PAY" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_ORDER_SUM"),
        "DESCR" => GetMessage("RFICB.PAYMENT_ORDER_SUM_DESC"),
        "VALUE" => "SHOULD_PAY",
        "TYPE" => "ORDER",
    ),
    "PHONE" => array(
       "NAME" => GetMessage("RFICB.PHONE_NAME"),
       "DESCR" => GetMessage("RFICB.PHONE_DESC"),
       "VALUE" => "PHONE",
       "TYPE" => "PROPERTY",
    ),
"COMMISSION" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_COMMISSION"),
        "DESCR" => GetMessage("RFICB.PAYMENT_COMMISSION_DESC"),
        "VALUE" => "0",
        "TYPE" => "",
    ),
"PAY_CART" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_CART"),
        "DESCR" => GetMessage("RFICB.PAYMENT_SELECTPAY_DESC"),
        "VALUE" => "1",
        "TYPE" => "",
    ),
"PAY_WM" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_WM"),
        "DESCR" => GetMessage("RFICB.PAYMENT_SELECTPAY_DESC"),
        "VALUE" => "1",
        "TYPE" => "",
    ),
"PAY_YM" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_YM"),
        "DESCR" => GetMessage("RFICB.PAYMENT_SELECTPAY_DESC"),
        "VALUE" => "1",
        "TYPE" => "",
    ),
"PAY_MC" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_MC"),
        "DESCR" => GetMessage("RFICB.PAYMENT_SELECTPAY_DESC"),
        "VALUE" => "1",
        "TYPE" => "",
    ),
"PAY_QIWI" => Array(
        "NAME" => GetMessage("RFICB.PAYMENT_QIWI"),
        "DESCR" => GetMessage("RFICB.PAYMENT_SELECTPAY_DESC"),
        "VALUE" => "1",
        "TYPE" => "",
    ),
);
?>
