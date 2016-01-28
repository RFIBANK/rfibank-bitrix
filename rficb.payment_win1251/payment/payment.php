<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeModuleLangFile(__FILE__);
if(!CModule::IncludeModule("rficb.payment")) return;?>
<link rel="stylesheet" type="text/css" href="/bitrix/themes/.default/rficb.css" /> 

<?php

$order_id = CSalePaySystemAction::GetParamValue("ORDER_ID");
$date = CSalePaySystemAction::GetParamValue("DATE_INSERT");
$cost = CSalePaySystemAction::GetParamValue("SHOULD_PAY");
$email = CUser::GetEmail ();
$com = CSalePaySystemAction::GetParamValue("COMMISSION");

$cart = CSalePaySystemAction::GetParamValue("PAY_CART");
$wm = CSalePaySystemAction::GetParamValue("PAY_WM");
$ym = CSalePaySystemAction::GetParamValue("PAY_YM");
$mc = CSalePaySystemAction::GetParamValue("PAY_MC");
$qiwi = CSalePaySystemAction::GetParamValue("PAY_QIWI");

$phone = CSalePaySystemAction::GetParamValue("PHONE");

//if($cart && $wm && $ym && $mc && $qiwi && $phone) $i=2;
//else 
$i=3;
if(!($arOrder = CSaleOrder::GetByID($order_id))) return;


$name = GetMessage("RFICB.PAYMENT_PAYMENT_FOR_ORDER",
        array("#DATE#" => $date,"#ORDER_ID#" => $order_id));
$key = CRficbPayment::GetKey($arOrder["LID"]);
?>
<script language="javascript" type="text/javascript">
function ptype(paytype){
document.getElementById("payment_type").value = paytype;  

 } </script>
<form method="POST"  class="application"  accept-charset="UTF-8" action="https://partner.rficb.ru/a1lite/input" target="_blank">
    <input type="hidden" name="key" value="<?echo $key?>" />
    <input type="hidden" name="cost" value="<?echo $cost?>" />
    <input type="hidden" name="name" value="<?echo $name?>" />
    <input type="hidden" name="email" value="<?echo $email?>" />
    <input type="hidden" name="order_id" value="0" />
    <input type="hidden" name="comment" value="<?echo $order_id?>" />
	<?if ($com) {
		echo '<input type="hidden" name="commission" value="abonent" />';
		echo '<input type="hidden" name="version" value="2.0" />';
 }
		else { 
			  if($cart) {
?>
<input type="hidden" name="payment_type" value="spg" id="payment_type" />
<div id="pay-methods" >
            <div class="row">
				<div class="col-xs-<?php echo $i;?> pay-method spg">
                <input type="radio" name="pay_type" id="pay-method-spg" value="spg" checked="" onclick="ptype('spg')">
                <label for="pay-method-spg"><span>Visa / MasterCard</span></label>
              </div>

				<?php }
			if ($email) { 
						 if ($wm) {?>
 <div class="col-xs-<?php echo $i;?> pay-method wm">
                <input type="radio" name="pay_type" id="pay-method-wm" value="wm" onclick="ptype('wm')">
                <label for="pay-method-wm"><span>WebMoney</span></label>
				</div> <?php }
 					if ($wm) {?>
              <div class="col-xs-<?php echo $i;?> pay-method ym">
                <input type="radio" name="pay_type" id="pay-method-ym" value="ym" onclick="ptype('ym')">
                <label for="pay-method-ym"><span>Яндекс. Деньги</span></label>
              </div>
				<?php } 
				}
			if ($phone) { 
if ($mc) {?>
<input type="hidden" name="phone_number" value="<?echo $phone?>" />
  <div class="col-xs-<?php echo $i;?> pay-method mc">
                <input type="radio" name="pay_type" id="pay-method-mc" value="mc" onclick="ptype('mc')">
                <label for="pay-method-mc"><span>Мобильный платёж</span></label>
              </div>
 <?php }
 					if ($qiwi) {?>
  <div class="col-xs-<?php echo $i;?> pay-method qiwi">
                <input type="radio" name="pay_type" id="pay-method-qiwi" value="qiwi" onclick="ptype('qiwi')">
                <label for="pay-method-qiwi"><span>QIWI</span></label>
              </div>
				<?php }
} ?>
            </div>
          </div>
<?php
	 	}
?>

    <?=GetMessage("RFICB.PAYMENT_FORM_SUBMIT")?>
</form>
