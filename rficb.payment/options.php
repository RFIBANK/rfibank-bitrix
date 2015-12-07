<?
$module_id = "rficb.payment";
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/include.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/options.php");


$sRights = $APPLICATION->GetGroupRight($module_id);
/*$arAllOptions = Array(
    Array("key", GetMessage("RFICB.PAYMENT_OPTIONS_KEY")." ",
         GetMessage("RFICB.PAYMENT_OPTIONS_KEY_DESC")),
    Array("secret_key", GetMessage("RFICB.PAYMENT_OPTIONS_SECRET_KEY")." ",
         GetMessage("RFICB.PAYMENT_OPTIONS_SECRET_KEY_DESC")),
);*/
$arError = Array();
if ($sRights>="R"):


$arPost=Array();
if(($sRights>="W") && ($REQUEST_METHOD=="POST") && strlen($Update)>0 && check_bitrix_sessid())
{
	if(preg_match("#^site_(\S+)$#",$_POST["tabControl_active_tab"],$arMatches))
	{
		$sSiteID = $arMatches[1];
		foreach($_POST["_update"][$sSiteID] as $sKey=>$sValue)
		{
			$arPost[$sSiteID][$sKey]=$sValue;
			if(!strlen(trim($sValue)))
			{
				$arError[]=$sKey;
			}
		}
		if(empty($arError))
		{
			foreach($_POST["_update"][$sSiteID] as $sKey=>$sValue)
			{
				COption::SetOptionString($module_id, "{$sSiteID}_{$sKey}", $sValue);
			}
		}
	}
}


/*================== Old values ====================*/
$sDefaultKey = COption::GetOptionString($module_id, "key","");
$sDefaultSecretKey = COption::GetOptionString($module_id, "secret_key","");
/*==================================================*/

$obSites = CSite::GetList($a="sort",$b="asc",Array());
$arSites = Array();
while($arSite = $obSites->Fetch())
{
	$arSite["DATA"]=Array(
		"url"=>Array(
			"value"=>"http://{$arSite["SERVER_NAME"]}/bitrix/tools/rficb.payment/result.php",
			"big_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_SCRIPT_URL"),
			"small_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_SCRIPT_URL_DESC")
		),
		"key"=>Array(
			"value"=>isset($arPost[$arSite["LID"]]["key"])?$arPost[$arSite["LID"]]["key"]:COption::GetOptionString($module_id, "{$arSite["LID"]}_key",$sDefaultKey),
			"name"=>"_update[{$arSite["LID"]}][key]",
			"big_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_KEY"),
			"small_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_KEY_DESC")
		),
		"secret_key"=>Array(
			"value"=>isset($arPost[$arSite["LID"]]["secret_key"])?$arPost[$arSite["LID"]]["secret_key"]:COption::GetOptionString($module_id, "{$arSite["LID"]}_secret_key",$sDefaultSecretKey),
			"name"=>"_update[{$arSite["LID"]}][secret_key]",
			"big_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_SECRET_KEY"),
			"small_text"=>GetMessage("RFICB.PAYMENT_OPTIONS_SECRET_KEY_DESC")
		)
	);
	$arSites[]=$arSite;
}

$aTabs = array();
foreach($arSites as $arSite)
{
	$aTabs[]=array("DIV" => "site_{$arSite["LID"]}", "TAB" => $arSite["NAME"]." [{$arSite["LID"]}]",
		"ICON" => "rficb.payment_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET"));
}
$aTabs[] = array("DIV" => "editrights", "TAB" => GetMessage("MAIN_TAB_RIGHTS"), "ICON" => "", "TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS"));
$tabControl = new CAdminTabControl("tabControl", $aTabs);

if(!empty($arError))
{
	$arErrorsString = Array();

	foreach($arError as $sKey)
	{
		$sName = GetMessage("RFICB.PAYMENT_OPTIONS_".ToUpper($sKey));
		$arErrorsString[]=GetMessage("RFICB.PAYMENT_OPTIONS_ERROR",Array("#FIELD#"=>$sName));
	}
	CAdminMessage::ShowMessage(Array("TYPE"=>"ERROR", "MESSAGE" =>implode("<br/>",$arErrorsString), "DETAILS"=>"", "HTML"=>true));
}

$tabControl->Begin();
?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialchars($mid)?>&lang=<?=LANGUAGE_ID?>">
	<?=bitrix_sessid_post()?>
	<?foreach($arSites as $arSite):?>
		<?$tabControl->BeginNextTab();?>
		<tr>
			<td valign="top" width="50%" style="text-align: right">
				<label for="id_install_public">
					<?=$arSite["DATA"]["url"]["big_text"]?><br/>
					<small><?=$arSite["DATA"]["url"]["small_text"]?></small>
				</label>
			</td>
			<td valign="top" width="50%" style="text-align: left">
				<strong><?=$arSite["DATA"]["url"]["value"]?></strong>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%" style="text-align: right">
				<label for="id_install_public">
					<?=$arSite["DATA"]["key"]["big_text"]?><br/>
					<small><?=$arSite["DATA"]["key"]["small_text"]?></small>
				</label>
			</td>
			<td valign="top" width="50%" style="text-align: left">
				<input type="text" name="<?=$arSite["DATA"]["key"]["name"]?>" value="<?=$arSite["DATA"]["key"]["value"]?>">
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%" style="text-align: right">
				<label for="id_install_public">
					<?=$arSite["DATA"]["secret_key"]["big_text"]?><br/>
					<small><?=$arSite["DATA"]["secret_key"]["small_text"]?></small>
				</label>
			</td>
			<td valign="top" width="50%" style="text-align: left">
				<input type="text" name="<?=$arSite["DATA"]["secret_key"]["name"]?>" value="<?=$arSite["DATA"]["secret_key"]["value"]?>">
			</td>
		</tr>
	<?endforeach;?>
	<?
	$tabControl->BeginNextTab();
	?>
	<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
	<?$tabControl->Buttons();?>

	<input type="submit" <?if ($sRights<"W") echo "disabled" ?> name="Update" value="<?echo GetMessage("MAIN_SAVE")?>">
	<!--<input type="submit" name="reset" value="<?/*echo GetMessage("MAIN_RESET")*/?>">-->
	<?$tabControl->End();?>
</form>

<?endif?>