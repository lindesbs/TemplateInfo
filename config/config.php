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



define("LF","\r\n");
define("TAB1","\t");
define("TAB2","\t\t");
    
    
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][]=array('FrontendTemplateInfo', 'parseTemplate');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][]=array('FrontendTemplateInfo', 'outputTemplate');

$GLOBALS['TL_HOOKS']['generateFrontendUrl'][]=array('FrontendTemplateInfo', 'generateFrontendURL');
$GLOBALS['TL_CSS'][] = 'system/modules/TemplateInfo/html/templateinfo.css';
$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/TemplateInfo/html/templateinfo.js';

array_insert($GLOBALS['BE_MOD']['system'], -1, array
(
    'TemplateInfo' => array (
        'callback'   => 'BackendTemplateInfo',
        'icon'       => 'system/modules/TemplateInfo/TemplateInfo.png',
    )
));

 
?>