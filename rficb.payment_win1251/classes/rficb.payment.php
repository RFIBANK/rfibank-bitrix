<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CRficbPayment {
    static $module_id = "rficb.payment";

    static function GetKey($sSiteID="")
	{
		$sKey = COption::GetOptionString(CRficbPayment::$module_id, "{$sSiteID}_key", "");
		if(!strlen($sKey)) COption::GetOptionString(CRficbPayment::$module_id, "key", ""); // Old version
        return $sKey;
    }

    static function GetSecretKey($sSiteID="")
	{
		$sSecretKey = COption::GetOptionString(CRficbPayment::$module_id, "{$sSiteID}_secret_key", "");
		if(!strlen($sSecretKey)) COption::GetOptionString(CRficbPayment::$module_id, "_secret_key", ""); // Old version
        return $sSecretKey;
    }

    function VerifyCheck($data,$sSiteID="")
	{
        $parameters = array ($data["tid"], $data["name"], $data["comment"], 
            $data["partner_id"], $data["service_id"], $data["order_id"], $data["type"],
            $data["partner_income"], $data["system_income"],$data["test"],CRficbPayment::GetSecretKey($sSiteID));
        $given_check = $data["check"];
        $generated_check = md5(join('',$parameters));
        return ($given_check === $generated_check);
    }   
}
?>
