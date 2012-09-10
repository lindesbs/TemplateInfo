<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Stefan Lindecke 2008
 * @author     Stefan Lindecke
 * @package    templateinfo
 * @license    GPL
 * @filesource
 */


/**
 * Class FrontendTemplateInfo
 *
 * @copyright  Stefan Lindecke 2008
 * @author     Stefan Lindecke
 * @package    Controller
 */
class FrontendTemplateInfo extends Frontend
{
	protected  $PreviewModeEnabled;


	public function outputTemplate($strBuffer, $strTemplate)
	{
		$cookieName = "TemplateInfo";
	
		if ($this->PreviewModeEnabled==1)
		{
		
			$posX=$this->Input->post('TemplateInfo_X');
			$posY=$this->Input->post('TemplateInfo_Y');
		
		
			if (strlen($posX))
			{
				$pos['X']=$posX;
			}
			
			if (strlen($posY))
			{
				$pos['Y']=$posY;
			}	
			
			
		
			
			$availableTemplates= $_SESSION['TemplateInfoNames'];

			$tableText = LF."<!-- TemplateInfo start -->".LF;
			$tableText .='<div class="TemplateInfoBox" id="TemplateInfo" style="left:'.$pos['X'].';top:'.$pos['Y'].';">'.LF;						
			$tableText .='<div class="TemplateInfoHeader">'.$GLOBALS['TL_LANG']['TemplateInfo']['TemplateInfoBoxTitle'].'</div>';
			
			$tableText .='<div class="dragger">X</div>'.LF;
			$tableText .= sprintf(TAB1.'<form action="%s" method="post" name="TemplateInfo">',$this->generateFrontendURL("","",
			$this->Environment->base .$this->Environment->request)).LF;

			
			$tableText .='<input type="hidden" name="REQUEST_TOKEN" value="{{request_token}}" />'.LF;
			$tableText .='<input type="hidden" id="TemplateInfo_X"  name="TemplateInfo_X" value="'.$pos['X'].'" />'.LF;
			$tableText .='<input type="hidden" id="TemplateInfo_Y"  name="TemplateInfo_Y" value="'.$pos['Y'].'" />'.LF;
			
			
			sort($availableTemplates);

			foreach ($availableTemplates as $tempName)
			{
				$checked = "unchecked";

				if ((!is_array($_POST["TemplateInfoList"]) || in_array($tempName,$_POST["TemplateInfoList"])))
				{
					$checked = "checked";
				}

				$tableText.=sprintf(TAB2.'<input type="checkbox" name="TemplateInfoList[]" value="%s" %s>%s<br>'.LF,
				$tempName,
				$checked,
				$tempName);
			}

			$tableText .='<input type="submit" name="submit" value="'.$GLOBALS['TL_LANG']['TemplateInfo']['SubmitButton'].'" />'.LF;
			$tableText .='<input type="button" name="CheckAll" value="'.$GLOBALS['TL_LANG']['TemplateInfo']['CheckAll'].'" onClick="SetCheck(this,true)">'.LF;
			$tableText .='<input type="button" name="UnCheckAll" value="'.$GLOBALS['TL_LANG']['TemplateInfo']['UncheckAll'].'" onClick="SetCheck(this,false)">'.LF;

			$tableText.= "</form>".LF;
			$tableText.= "<br>".LF;


			$tableText .='</div>'.LF;

			$tableText .= "<!-- TemplateInfo end -->".LF;
			$finder = "<body";

			$bodyPos = strpos($strBuffer,$finder);
			$bodyPosEnd = strpos($strBuffer,">",$bodyPos)+1;



			$strBufferNew = $strBuffer;

			if ($bodyPosEnd>1)
			{
				// inject my code directly after BODY

				$strBufferNew = substr($strBuffer,0,$bodyPosEnd).$tableText.substr($strBuffer,$bodyPosEnd,strlen($strBuffer)-$bodyPosEnd);
			}



			$this->PreviewModeEnabled=0;
			unset ($_SESSION['TemplateInfoVisibleItems']);
				
			return $strBufferNew;

		}
		
		return $strBuffer;
	}
	public function parseTemplate($strBuffer, $strTemplate)
	{
		$previewMode=$this->Input->get('previewMode');
		$sessionMode =$_SESSION['TemplateInfo'];
		$displayTemplates = $_POST["TemplateInfoList"];

		$_SESSION['TemplateInfoNames'][$strTemplate]=$strTemplate;


		if ((strpos($_SERVER["HTTP_REFERER"],'TemplateInfoPreview.php')!=FALSE))
		{
			$previewMode=$sessionMode;
		}
		else
		if ((!empty($previewMode)) && (strcmp($previewMode,$sessionMode)!=0))
		{
			return $GLOBALS['TL_LANG']['TemplateInfo']['WrongID'];
			break;
		}

		if (!empty($previewMode) && !empty($sessionMode) && ($previewMode==$sessionMode))
		{

			$this->PreviewModeEnabled=1;
			$stackArray = debug_backtrace();

			foreach ($stackArray as $stackInfo)
			{
				$backtraceInfo['BackTrace'][] =  array(
					"File" => $stackInfo['file'],
					"Function"=>$stackInfo['function'],
					"Line" =>$stackInfo['line']
				);
			}
			$backtraceInfo['TemplateName'] = $strTemplate;
			$backtraceInfo['TemplateDir'] = $this->getTemplate($strTemplate);

			$templateDir = $this->getTemplate($strTemplate);
			$Template = new FrontendTemplate($this->getTemplate($strTemplate));


			$requestURL = $this->Environment->base;
			$serializeData = serialize($backtraceInfo);
			$encodedData = base64_encode($serializeData);

			$parentInText = "parent.TemplateInfoProperties.location.href='".$requestURL."/system/modules/TemplateInfo/TemplateInfoPreviewProperties.php?info=".$encodedData."';";

			$infobox = '<a class="infobox" id="Test" onmousedown="'.$parentInText.'">[TEMPLATE:'.$strTemplate.']</a>';


			if ((is_array($displayTemplates) && in_array($strTemplate,$displayTemplates)) ||
			(!is_array($displayTemplates)))
			{
				$strBuffer = '<div class="templateinfo">'.$infobox.$strBuffer.'</div>';
			}

		}
		return $strBuffer;
	}


	
	public function generateFrontendURL ($arrRow, $strParams, $strUrl)
	{

		if (strpos($strUrl,"previewMode")==false)
		{
			$sessionMode = $_SESSION['TemplateInfo'];

			if ((isset($sessionMode) && 
				(($this->Input->get('previewMode')==$sessionMode) ||
					(strpos($_SERVER["HTTP_REFERER"],'TemplateInfoPreview.php')!=FALSE))))
			{
				if (strpos($strUrl,"?")==false)
				$strUrl.="?";
				else
				$strUrl.="&";

					
				$strUrl.="previewMode=".$sessionMode;
			}
		}
		return $strUrl;
	}




}

?>
