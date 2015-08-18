<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ********************************************************************************************
 * Stock_helper : Helper to generate JS/HTML in view
 *
 *
 *
 *********************************************************************************************/

/* *** Generate a Javascript dynamic dropdown for filters *** */

if ( ! function_exists('js_drop_down'))
{
    function js_drop_down($opt, $dd_array, $url ='')
    {
    	
    	
    	$dd = '<select id="'.$opt.'" onchange="_func_'.$opt.'()">';

    	foreach ($dd_array as $array){
    		$dd .= '<option value="'.$array['value'].'"';
    		
    		if($array['value'] < 1)
    		{
    			$dd .= ' selected disabled';
    		}
    		
    		$dd .= '>'.$array['text'].'</option>';	
    	}
    	
    	$dd .= '</select>';
    	
    	$dd .= '<script>';
    	$dd .= 'function _func_'.$opt.'() {';
    	$dd .= 'var val_opt = document.getElementById("'.$opt.'").value;';
    	$dd .= 'if(val_opt<0) {return;}';
    	
    	$dd .= 'window.location.href="'.$url.$opt.'/"+val_opt;';
    	$dd .= '}';
    	$dd .= '</script>';
    	$dd .= "\n";
    	
        return $dd;
    }   
}

/* *** Generate a standard dropdown from an array *** */

if ( ! function_exists('stock_drop_down'))
{
	function stock_drop_down($opt, $dd_array, $index, $field, $id_selected = NULL, $dd_title = NULL)
	{

		$dd = '<select name="'.$opt.'">';
		
		if($id_selected == NULL)
			if($dd_title != NULL)
				$dd .= '<option selected disabled>'.$dd_title.'</option>';

		foreach ($dd_array as $array){
			$dd .= '<option value="'.$array[$index].'"';

				if($array[$index] == $id_selected)
				{
					$dd .= ' selected="selected"';
				}
			
			$dd .= '>'.$array[$field].'</option>';

		}
		 
		$dd .= '</select>';
		 
		$dd .= "\n";
		 
		return $dd;
	}
}