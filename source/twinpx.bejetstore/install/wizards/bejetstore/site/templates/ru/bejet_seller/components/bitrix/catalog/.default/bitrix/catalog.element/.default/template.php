<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);

$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?><div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<div class="row">
<?
if ('Y' == $arParams['DISPLAY_NAME'])
{
?>
<div class="bx_item_title">
	<h1>
		<span><? echo (
			isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arResult["NAME"]
		); ?></span>
	</h1>
</div>
<?
}
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
<div class="col-sm-6">
<?//print_r($arResult['MORE_PHOTO'] )?>
	<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
		<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
			<div class="bx_bigimages_imgcontainer">
				<span class="bx_bigimages_aligner"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>" ></span>
				<?
				if (('Y' == $arParams['SHOW_DISCOUNT_PERCENT'] && 0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']) || $arResult['LABEL'])
				{
				?>
					<div class="bj-gallery-info">
					<?
					if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'] && 0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF'])
					{
					?>
						<span class="bj-gallery-info__i i-discount" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></span>
						<?if ($arResult['LABEL'])
						{
						?>
										<span class="i-sep"></span>
						<?
						}
						?>
					<?
					}
					?>
					<?				
					if ($arResult['LABEL'])
					{
					?>
						<span class="bj-gallery-info__i i-new" id="<? echo $arItemIDs['STICKER_ID'] ?>"><? echo $arResult['LABEL_VALUE']; ?></span>
					<?
					}
					?>
					</div>
				<?
				}
				?>
			</div>
		</div>
		
		<?
		if ($arResult['SHOW_SLIDER'])
		{
			if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
			{
				if (5 < $arResult['MORE_PHOTO_COUNT'])
				{
					$strClass = 'bx_slider_conteiner full';
					$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
					$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_slider_conteiner';
					$strOneWidth = '20%';
					$strWidth = '100%';
					$strSlideStyle = 'display: none;';
				}
				?>
				<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
					<div class="bx_slider_scroller_container">
						<div class="bx_slide">
							<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
							<?
								foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
								{
							?>
									<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
							<?
								}
								unset($arOnePhoto);
							?>
							</ul>
						</div>
						<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
				</div>
			<?
			}
			else
			{
				foreach ($arResult['OFFERS'] as $key => $arOneOffer)
				{
					if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
						continue;
					$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
					if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
					{
						$strClass = 'bx_slider_conteiner full';
						$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
						$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_slider_conteiner';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
					?>
					<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
						<div class="bx_slider_scroller_container">
							<div class="bx_slide">
								<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
									<?
									foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
									{
									?>
										<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
									<?
									}
									unset($arOnePhoto);
									?>
								</ul>
							</div>
							<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
							<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
						</div>
					</div>
					<?
				}
			}
		}
		?>
	</div>


</div>
<hr class="visible-xs-block">
<div class="col-sm-6">
<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
if ($useVoteRating)
{
?>
	<div class="row">
		<div class="col-sm-6">
			<?$APPLICATION->IncludeComponent(
				"bitrix:iblock.vote",
				"bejetstore",
				array(
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"ELEMENT_ID" => $arResult['ID'],
					"ELEMENT_CODE" => "",
					"MAX_VOTE" => "5",
					"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
					"SET_STATUS_404" => "N",
					"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
					"CACHE_TYPE" => $arParams['CACHE_TYPE'],
					"CACHE_TIME" => $arParams['CACHE_TIME']
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
		</div>
	</div>
	<hr class="i-line i-size-L">
<?
}
unset($useVoteRating);
?>
<div class="row small">
	<div class="col-sm-6" id="<? echo $arItemIDs['PROP_DIV']; ?>">
	<?
	if ('' != $arResult['PREVIEW_TEXT'])
	{
		if (
			'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']
			|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
		)
		{
	/*?>
	<hr><?*/?>
	<div class="item_info_section">
	<h3>Описание</h3>
	<?
			echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
	?>
	</div>
	<hr>
	<?
		}
	}?>
	<?if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
	{
		$arSkuProps = array();
	?>
	<?
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
				continue;
			$arSkuProps[] = array(
				'ID' => $arProp['ID'],
				'SHOW_MODE' => $arProp['SHOW_MODE'],
				'VALUES_COUNT' => $arProp['VALUES_COUNT']
			);
			
			if ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strWidth = (20*$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strOneWidth = '20%';
					$strWidth = '100%';
					$strSlideStyle = 'display: none;';
				}
	?>
		<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
			<h3><? echo htmlspecialcharsex($arProp['NAME']); ?></h3>
			<div class="bx_scu_scroller_container"><div class="bx_scu">
				<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
	<?
				foreach ($arProp['VALUES'] as $arOneValue)
				{
	?>
					<li
						data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
						data-onevalue="<? echo $arOneValue['ID']; ?>"
						style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;"
					><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
					<span class="cnt"><span class="cnt_item"
						style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
						title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
					></span></span></li>
	<?
				}
	?>
				</ul>
				</div>
				<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
				<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			</div>
		</div>
		<hr>
	<?
			}
			elseif ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_size full';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strWidth = (20*$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_size';
					$strOneWidth = '20%';
					$strWidth = '100%';
					$strSlideStyle = 'display: none;';
				}
	?>
		<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
			<h3><? echo htmlspecialcharsex($arProp['NAME']); ?></h3>
			<div class="bx_size_scroller_container"><div class="bx_size">
				<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
	<?
				foreach ($arProp['VALUES'] as $arOneValue)
				{
	?>
					<li
						data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"
						data-onevalue="<? echo $arOneValue['ID']; ?>"
						style="width: <? echo $strOneWidth; ?>; display: none;"
					><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li>
	<?
				}
	?>
				</ul>
				</div>
				<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
				<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			</div>
		</div>
		<hr>
	<?
			}
		}
		unset($arProp);
	?>
	
	<?
	}
	?>
	<div class="bj-catalog-price-block">
		<div class="bj-price i-size-L">
		<?
		$boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
		?>
			<!--add class "text-large"-->
			<div class="text-large <? echo ($boolDiscountShow ? 'text-info item_economy_price' : 'item_current_price'); ?>" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
			<!--add classes "text-large text-info"-->
			<div class="small text-muted" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
			<!--add class "text-small"-->
			<div class="text-small item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>">
			<? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?>
			</div>
		</div>
		<div class="bj-catalog-pb__hr"></div>
		<?/*?><div class="text-center">
          Доступно: 3 шт
        </div>
        <div class="bj-catalog-pb__hr"></div><?*/?>
		<div class="text-center">
		<?
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
			$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
		}
		else
		{
			$canBuy = $arResult['CAN_BUY'];
		}
		if ($canBuy)
		{
			$buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
			$buyBtnClass = 'bx_big bx_bt_button bx_cart';
		}
		else
		{
			$buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
			$buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
		}
		if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
		{
		?>
		<span class="item_buttons_counter_block">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
			<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
					? 1
					: $arResult['CATALOG_MEASURE_RATIO']
				); ?>">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
			<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
		</span>
		<?
		}
		else
		{
		?>
			<div class="item_buttons vam">
				<span class="item_buttons_counter_block">
					<a href="javascript:void(0);" class="<? echo $buyBtnClass; ?>" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
		<?
			if ('Y' == $arParams['DISPLAY_COMPARE'])
			{
		?>
					<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" style="margin-left: 10px"><? echo ('' != $arParams['MESS_BTN_COMPARE']
							? $arParams['MESS_BTN_COMPARE']
							: GetMessage('CT_BCE_CATALOG_COMPARE')
						); ?></a>
		<?
			}
		?>
				</span>
			</div>
		<?
		}
		?>		
		</div>
	</div>		
		<hr>
		<div class="text-center">
			<a href="javascript:void(0);" class="btn btn-default btn-size-L btn-100 bj-cart-button" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
		</div>
		</div>

		<hr class="visible-xs-block">
		<div class="col-sm-6">
			<div class="row">
				<?if(strlen($arResult['DISPLAY_PROPERTIES']["BRAND"]["PICTURE_SRC"])):?>
				<div class="text-center bj-catalogue-label col-xs-6 col-sm-12 no-float-sm">
					<div class="bj-catalogue-label__icon">
					<?if($arResult['DISPLAY_PROPERTIES']["BRAND"]["LINK_ELEMENT_VALUE"][$arResult['DISPLAY_PROPERTIES']["BRAND"]["VALUE"]]["DETAIL_PAGE_URL"]):?>
						<a href="<?=$arResult['DISPLAY_PROPERTIES']["BRAND"]["LINK_ELEMENT_VALUE"][$arResult['DISPLAY_PROPERTIES']["BRAND"]["VALUE"]]["DETAIL_PAGE_URL"]?>"><img src="<?=$arResult['DISPLAY_PROPERTIES']["BRAND"]["PICTURE_SRC"]?>" class="img-responsive center-block"></a>
					<?else:?>
						<img src="<?=$arResult['DISPLAY_PROPERTIES']["BRAND"]["PICTURE_SRC"]?>" class="img-responsive center-block">
					<?endif;?>
					</div>
				</div>
				<hr class="hidden-xs">
				<?endif;?>
				<div class="col-xs-6 col-sm-12 no-float-sm">
				<?
				if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
				{
					if (!empty($arResult['DISPLAY_PROPERTIES']))
					{
						foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
						{
							if($arOneProp["CODE"] != "CHARACTERISTICS" && $arOneProp["CODE"] != "BRAND"){
								?><h3><? echo $arOneProp['NAME']; ?></h3><?
								echo '', (
									is_array($arOneProp['DISPLAY_VALUE'])
									? implode(' / ', $arOneProp['DISPLAY_VALUE'])
									: $arOneProp['DISPLAY_VALUE']
								), '';				
							}
						}
						unset($arOneProp);
					}
				}
				?>
				</div>
			</div>
			<hr>
			<?
			if ($useBrands)
			{
				?><?$APPLICATION->IncludeComponent("bejetstore:catalog.brandblock", "bejetstore", array(
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"ELEMENT_ID" => $arResult['ID'],
					"ELEMENT_CODE" => "",
					"BRAND_ID" => $arResult["PROPERTIES"]["BRAND"]["VALUE"],
					"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
					"CACHE_TYPE" => $arParams['CACHE_TYPE'],
					"CACHE_TIME" => $arParams['CACHE_TIME'],
					"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
					"WIDTH" => "65",
					"HEIGHT" => "65",
					"WIDTH_SMALL" => "65",
					"HEIGHT_SMALL" => "65"
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?><?
			}unset($useBrands);?>
		</div>
</div>
</div>
</div></div>
<hr>
<div class="bj-catalogue-nav-tabs">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs bj-nav-tabs" role="tablist">
		<?if ('Y' == $arParams['USE_COMMENTS']){?><li class="active"><a href="#comments" role="tab" data-toggle="tab">Отзывы</a></li><?}?>
		<?if ('' != $arResult['DETAIL_TEXT']){?><li><a href="#info" role="tab" data-toggle="tab"><? echo GetMessage('FULL_DESCRIPTION'); ?></a></li><?}?>
		<?if ('' != $arResult['DISPLAY_PROPERTIES']["CHARACTERISTICS"]["VALUE"]["TEXT"]){?><li><a href="#props" role="tab" data-toggle="tab"><?=$arResult['DISPLAY_PROPERTIES']["CHARACTERISTICS"]["NAME"]?></a></li><?}?>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="comments">
			<?
			if ('Y' == $arParams['USE_COMMENTS'])
			{
			?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.comments",
				".default",//"bejetstore",
				array(
					"ELEMENT_ID" => $arResult['ID'],
					"ELEMENT_CODE" => "",
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"URL_TO_COMMENT" => "",
					"WIDTH" => "",
					"COMMENTS_COUNT" => "5",
					"BLOG_USE" => $arParams['BLOG_USE'],
					"FB_USE" => $arParams['FB_USE'],
					"FB_APP_ID" => $arParams['FB_APP_ID'],
					"VK_USE" => $arParams['VK_USE'],
					"VK_API_ID" => $arParams['VK_API_ID'],
					"CACHE_TYPE" => $arParams['CACHE_TYPE'],
					"CACHE_TIME" => $arParams['CACHE_TIME'],
					"BLOG_TITLE" => "",
					"BLOG_URL" => $arParams['BLOG_URL'],
					"PATH_TO_SMILE" => "",
					"EMAIL_NOTIFY" => "N",
					"AJAX_POST" => "Y",
					"SHOW_SPAM" => "Y",
					"SHOW_RATING" => "N",
					"FB_TITLE" => "",
					"FB_USER_ADMIN_ID" => "",
					"FB_COLORSCHEME" => "light",
					"FB_ORDER_BY" => "reverse_time",
					"VK_TITLE" => "",
					"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
			<?
			}
			?>
		</div>
		<div class="tab-pane" id="info">
		<?
		if ('' != $arResult['DETAIL_TEXT'])
		{
		?>
		<?
			echo $arResult['DETAIL_TEXT'];
		?>
		<?
		}
		?>
		</div>
		<div class="tab-pane" id="props"><?=$arResult['DISPLAY_PROPERTIES']["CHARACTERISTICS"]["~VALUE"]["TEXT"]?></div>
	</div>
</div>
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
			'BUY_URL' => $arResult['~BUY_URL'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL']
		)
	);
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>