<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->IncludeComponent("bitrix:catalog.top", "", array(
	"IBLOCK_TYPE_ID" => "catalog",
	"IBLOCK_ID" => BEJET_SELLER_CLOTHES,
	"ELEMENT_SORT_FIELD" => "SORT",
	"ELEMENT_SORT_ORDER" => "asc",
	"ELEMENT_COUNT" => "6",
	"VIEW_MODE" => "BANNER",
	"TEMPLATE_THEME" => "site",
	"PROPERTY_CODE" => array(
		0 => "MINIMUM_PRICE",
		1 => "MAXIMUM_PRICE",
	),
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id_slider",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "180",
	"CACHE_GROUPS" => "Y",
	"DISPLAY_COMPARE" => "N",
	"PRICE_CODE" => array(
		0 => "BASE",
	),
	"OFFERS_FIELD_CODE" => array(
		0 => "NAME",
		1 => "",
	),
	"OFFERS_PROPERTY_CODE" => array(
		0 => "COLOR",
		1 => "WIDTH",
		2 => "",
	),
	"OFFERS_CART_PROPERTIES" => array(
		0 => "COLOR",
		1 => "WIDTH",
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"USE_PRODUCT_QUANTITY" => "Y"
	),
	false
);
?>