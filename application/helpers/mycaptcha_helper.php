<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter CAPTCHA Helper
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/xml_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Create CAPTCHA
 *
 * @access	public
 * @param	string	word type of : default, chars, num
 * @param	int 	img width
 * @param	int 	img_height
 * @return	array
 */
if ( ! function_exists('create_mycaptcha'))
{
	function mycaptcha($word_type, $len, $img_width, $img_height, $interfere, $font_path='')
	{
		
		if ( ! extension_loaded('gd'))
		{
			return FALSE;
		}
		$len = $len < 4 ? 4 : $len;
		$img_width = $img_width < 50 ? 50 : $img_width;
		$img_height= $img_height < 30 ? 30 : $img_height;
		$interfere = $interfere < 10 ? 10 : $interfere;
		
		// -----------------------------------
		// Do we have a "word" yet?
		// -----------------------------------

	   if ( $word_type == 'chars' ){
	   		$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   }elseif ( $word_type == 'num' ){
	   		$pool = '0123456789';
	   }else{
	   		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   }
		$word = '';
		for ($i = 0; $i < $len; $i++)
		{
			$word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		

		// -----------------------------------
		// Determine angle and position
		// -----------------------------------

		// -----------------------------------
		// Create image
		// -----------------------------------

		// PHP.net recommends imagecreatetruecolor(), but it isn't always available
		if (function_exists('imagecreatetruecolor'))
		{
			$im = imagecreatetruecolor($img_width, $img_height);
		}
		else
		{
			$im = imagecreate($img_width, $img_height);
		}

		// -----------------------------------
		//  Assign colors
		// -----------------------------------

		$bg_color		= imagecolorallocate($im, 255,255,255);
		$border_color	= imagecolorallocate($im, 0,0,0);
		$text_color		= imagecolorallocate($im, rand(50,200),rand(50,200),rand(50,200));

		// -----------------------------------
		//  Create the rectangle
		// -----------------------------------

		ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg_color);

		// -----------------------------------d
		//  Create the spiral pattern
		// -----------------------------------

		$theta		= 1;
		$thetac		= 7;
		$radius		= 16;
		$circles	= 20;
		$points		= 32;

		for($i=1;$i<$interfere;$i++){
			$linecolor  =   imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			$x  =   rand(1,$img_width);
			$y  =   rand(1,$img_height);
			$x2 =   rand($x-10,$x+10);
			$y2 =   rand($y-10,$y+10);
			imageline($im,$x,$y,$x2,$y2,$linecolor);
		}

		for($i=0;$i<$len;$i++){
			imagestring($im,5,$i*10+6,rand(2,5),$word[$i],$text_color);
		}
		
		// -----------------------------------
		//  Create the border
		// -----------------------------------

		imagerectangle($im, 0, 0, $img_width-1, $img_height-1, $border_color);		
		return array('word' => $word, 'image' => $im);
		
	}
}

// ------------------------------------------------------------------------

/* End of file captcha_helper.php */
/* Location: ./system/heleprs/captcha_helper.php */