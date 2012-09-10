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
 * Class BackendTemplateInfo 
 *
 * @copyright  Stefan Lindecke 2008 
 * @author     Stefan Lindecke 
 * @package    Controller
 */
class BackendTemplateInfo extends BackendModule
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_TemplateInfoConfig';
	
    
    protected function compile()
    {
    	$token = md5(uniqid(rand(), true));
    	
		$_SESSION['TemplateInfo'] = $token;		
		
    	$this->loadLanguageFile('default');
    	
    	$previewLink = $this->Environment->base."system/modules/TemplateInfo/TemplateInfoPreview.php";
    	
		$this->Template->WelcomeMessage = $GLOBALS['TL_LANG']['TemplateInfo']['WelcomeMessage'];
    	$this->Template->PreviewLink = '<a href="'.$previewLink.'" title="'.$GLOBALS['TL_LANG']['TemplateInfo']['PreviewTitle'].'" target="_blank">'.$GLOBALS['TL_LANG']['TemplateInfo']['PreviewMessage'].'</a>';;   	
    	
    	
    }    
}

?>
