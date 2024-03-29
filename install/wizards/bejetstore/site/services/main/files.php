<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
	return;

function ___writeToAreasFile($path, $text)
{
	//if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
	//	@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($path, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($path, BX_FILE_PERMISSIONS);
}

if (COption::GetOptionString("main", "upload_dir") == "")
	COption::SetOptionString("main", "upload_dir", "upload");

if(COption::GetOptionString("bejetstore", "wizard_installed", "N", WIZARD_SITE_ID) == "N" || WIZARD_INSTALL_DEMO_DATA)
{

	// public files
	if(file_exists(WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"))
	{
		CopyDirFiles(
			WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/",
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);
	}

	// private files
	/*if(file_exists(WIZARD_ABSOLUTE_PATH."/site/private/".LANGUAGE_ID."/"))
	{
		CopyDirFiles(
			WIZARD_ABSOLUTE_PATH."/site/private/".LANGUAGE_ID."/",
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);
	}*/
}

$wizard =& $this->GetWizard();
___writeToAreasFile(WIZARD_SITE_PATH."include/company_name.php", $wizard->GetVar("siteName"));
___writeToAreasFile(WIZARD_SITE_PATH."include/copyright.php", $wizard->GetVar("siteCopy"));
___writeToAreasFile(WIZARD_SITE_PATH."include/schedule.php", $wizard->GetVar("siteSchedule"));
___writeToAreasFile(WIZARD_SITE_PATH."include/telephone.php", $wizard->GetVar("siteTelephone"));

$siteLogo = $wizard->GetVar("siteLogo");
if(strlen($siteLogo)>0)
{
	if(IntVal($siteLogo) > 0)
	{
		$ff = CFile::GetByID($siteLogo);
		if($zr = $ff->Fetch())
		{
			$strOldFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$zr["SUBDIR"]."/".$zr["FILE_NAME"]);
			$path_parts = pathinfo($strOldFile);
			@copy($strOldFile, WIZARD_SITE_PATH."include/logo.".$path_parts['extension']);
			CFile::Delete($zr["ID"]);
			
			if("logo.".$path_parts['extension'] != "logo.png"){
				$strLogo = file_get_contents(WIZARD_SITE_PATH."include/company_logo.php");
				if($strLogo!==false)
				{
					$strLogo = str_replace("logo.png", "logo.".$path_parts['extension'], $strLogo);

				}
				else
					$strLogo = "";

				$filename = WIZARD_SITE_PATH."include/company_logo.php";
				if (is_writable($filename) && strlen($strLogo)) {

				    if (!$handle = fopen($filename, 'w')) {
				         echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_OPEN_ERROR"));
				         die;
				    }

				    if (fwrite($handle, $strLogo) === FALSE) {
				        echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_WRITE_ERROR"));
				        die;
				    }

				    fclose($handle);

				} else {
					echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_PERMISSION_DENIED"));
					die;
				}
			}			
		}
	}
}else{
	$strLogo = '<img width="143" alt="'.GetMessage("WIZ_FILE_ALT").'" src="'.WIZARD_SITE_DIR.'include/logo.png" height="40" title="'.GetMessage("WIZ_FILE_ALT").'">';
	$filename = WIZARD_SITE_PATH."include/company_logo.php";
	if (is_writable($filename) && strlen($strLogo)) {

	    if (!$handle = fopen($filename, 'w')) {
	         echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_OPEN_ERROR"));
	         die;
	    }

	    if (fwrite($handle, $strLogo) === FALSE) {
	        echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_WRITE_ERROR"));
	        die;
	    }

	    fclose($handle);

	} else {
		echo str_replace("#FILENAME#", $filename, GetMessage("WIZ_FILE_PERMISSION_DENIED"));
		die;
	}
}

if(COption::GetOptionString("bejetstore", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."login/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."store/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."campaign/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brand/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."journal/", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_search.php", Array("SITE_DIR" => WIZARD_SITE_DIR));

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SALE_EMAIL" => $wizard->GetVar("shopEmail")));

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/delivery/", Array("SALE_PHONE" => $wizard->GetVar("siteTelephone")));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));

copy(WIZARD_THEME_ABSOLUTE_PATH."/favicon.ico", WIZARD_SITE_PATH."favicon.ico");

$arUrlRewrite = array(); 
if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
}

$arNewUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	 WIZARD_SITE_DIR."news/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."catalog/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	 WIZARD_SITE_DIR."catalog/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."personal/order/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:sale.personal.order",
		"PATH"	=>	 WIZARD_SITE_DIR."personal/order/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."store/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog.store",
		"PATH"	=>	WIZARD_SITE_DIR."store/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."campaign/([a-zA-Z1-9_\\-]+)/(.)*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => WIZARD_SITE_DIR."campaign/detail.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."brand/([a-zA-Z1-9_\\-]+)/(.)*#",
		"RULE" => "BRAND_CODE=\$1",
		"ID" => "",
		"PATH" => WIZARD_SITE_DIR."brand/detail.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."about/vacancies/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."about/vacancies/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."journal/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."journal/index.php",
	)
);

foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
	{
		CUrlRewriter::Add($arUrl);
	}
}
?>