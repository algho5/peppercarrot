<?php
/**
 * Plugin linkMyComments
 *
 * Based on code of FluxBB
 * Copyright (C) 2008-2012 FluxBB
 * based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 *
 *
 * @package	PLX
 * @version	1.0
 * @date	14/01/2014
 * @author	Cyril MAGUIRE
 **/
	/**
	* @version $Id: trim.php,v 1.1 2006/02/25 13:50:17 harryf Exp $
	* @package utf8
	* @subpackage strings
	*/

	/**
	* UTF-8 aware replacement for ltrim()
	* Note: you only need to use this if you are supplying the charlist
	* optional arg and it contains UTF-8 characters. Otherwise ltrim will
	* work normally on a UTF-8 string
	* @author Andreas Gohr <andi@splitbrain.org>
	* @see http://www.php.net/ltrim
	* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
	* @return string
	* @package utf8
	* @subpackage strings
	*/
	function utf8_ltrim( $str, $charlist=false)
	{
		if($charlist === false)
			return ltrim($str);

		// Quote charlist for use in a characterclass
		$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!', '\\\${1}', $charlist);

		return preg_replace('/^['.$charlist.']+/u', '', $str);
	}

	/**
	* UTF-8 aware replacement for rtrim()
	* Note: you only need to use this if you are supplying the charlist
	* optional arg and it contains UTF-8 characters. Otherwise rtrim will
	* work normally on a UTF-8 string
	* @author Andreas Gohr <andi@splitbrain.org>
	* @see http://www.php.net/rtrim
	* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
	* @return string
	* @package utf8
	* @subpackage strings
	*/
	function utf8_rtrim($str, $charlist=false)
	{
		if($charlist === false)
			return rtrim($str);

		// Quote charlist for use in a characterclass
		$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!', '\\\${1}', $charlist);

		return preg_replace('/['.$charlist.']+$/u', '', $str);
	}

	//---------------------------------------------------------------
	/**
	* UTF-8 aware replacement for trim()
	* Note: you only need to use this if you are supplying the charlist
	* optional arg and it contains UTF-8 characters. Otherwise trim will
	* work normally on a UTF-8 string
	* @author Andreas Gohr <andi@splitbrain.org>
	* @see http://www.php.net/trim
	* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
	* @return string
	* @package utf8
	* @subpackage strings
	*/
	function utf8_trim( $str, $charlist=false)
	{
		if($charlist === false)
			return trim($str);

		return utf8_ltrim(utf8_rtrim($str, $charlist), $charlist);
	}

	/**
	* Wrapper round mb_strlen
	* Assumes you have mb_internal_encoding to UTF-8 already
	* Note: this function does not count bad bytes in the string - these
	* are simply ignored
	* @param string UTF-8 string
	* @return int number of UTF-8 characters in string
	* @package utf8
	* @subpackage strings
	*/
	function utf8_strlen($str)
	{
		return mb_strlen($str);
	}
	/**
	* Assumes mbstring internal encoding is set to UTF-8
	* Wrapper around mb_substr
	* Return part of a string given character offset (and optionally length)
	* @param string
	* @param integer number of UTF-8 characters offset (from left)
	* @param integer (optional) length in UTF-8 characters from offset
	* @return mixed string or FALSE if failure
	* @package utf8
	* @subpackage strings
	*/
	function utf8_substr($str, $offset, $length = false)
	{
		if ($length === false)
			return mb_substr($str, $offset);
		else
			return mb_substr($str, $offset, $length);
	}
	//
	// Fetch the current protocol in use - http or https
	//
	function get_current_protocol()
	{
		$protocol = 'http';

		// Check if the server is claiming to using HTTPS
		if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off')
			$protocol = 'https';

		// If we are behind a reverse proxy try to decide which protocol it is using
		if (defined('FORUM_BEHIND_REVERSE_PROXY'))
		{
			// Check if we are behind a Microsoft based reverse proxy
			if (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) != 'off')
				$protocol = 'https';

			// Check if we're behind a "proper" reverse proxy, and what protocol it's using
			if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
				$protocol = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
		}

		return $protocol;
	}


	//
	// Fetch the base_url, optionally support HTTPS and HTTP
	//
	function get_base_url($support_https = false)
	{
		global $pun_config;
		static $base_url;

		if (!$support_https)
			return $pun_config['o_base_url'];

		if (!isset($base_url))
		{
			// Make sure we are using the correct protocol
			$base_url = str_replace(array('http://', 'https://'), get_current_protocol().'://', $pun_config['o_base_url']);
		}

		return $base_url;
	}
	//
	// A wrapper for utf8_trim for compatibility
	//
	function pun_trim($str, $charlist = false)
	{
		return is_string($str) ? utf8_trim($str, $charlist) : '';
	}
	//
	// Calls htmlspecialchars with a few options already set
	//
	function pun_htmlspecialchars($str)
	{
		return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}
	//
	// Calls htmlspecialchars_decode with a few options already set
	//
	function pun_htmlspecialchars_decode($str)
	{
		if (function_exists('htmlspecialchars_decode'))
			return htmlspecialchars_decode($str, ENT_QUOTES);

		static $translations;
		if (!isset($translations))
		{
			$translations = get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES);
			$translations['&#039;'] = '\''; // get_html_translation_table doesn't include &#039; which is what htmlspecialchars translates ' to, but apparently that is okay?! http://bugs.php.net/bug.php?id=25927
			$translations = array_flip($translations);
		}

		return strtr($str, $translations);
	}
	//
	// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
	//
	function handle_url_tag($url, $link = '', $bbcode = false)
	{
		$url = pun_trim($url);
		$title = '';

		// Deal with [url][img]http://example.com/test.png[/img][/url]
		if (preg_match('%<img src=\\\\"(.*?)\\\\"%', $url, $matches))
			return handle_url_tag($matches[1], $url, $bbcode);

		$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
		if (strpos($url, 'www.') === 0) // If it starts with www, we add http://
			$full_url = 'http://'.$full_url;
		else if (strpos($url, 'ftp.') === 0) // Else if it starts with ftp, we add ftp://
			$full_url = 'ftp://'.$full_url;
		else if (strpos($url, '/') === 0) // Allow for relative URLs that start with a slash
			$full_url = get_base_url(true).$full_url;
		else if (!preg_match('#^([a-z0-9]{3,6})://#', $url)) // Else if it doesn't start with abcdef://, we add http://
			$full_url = 'http://'.$full_url;

		// Ok, not very pretty :-)
		if ($bbcode)
		{
			if ($full_url == $link)
				return '[url]'.$link.'[/url]';
			else
				return '[url='.$full_url.']'.$link.'[/url]';
		}
		else
		{
			if ($link == '' || $link == $url)
			{
				$url = pun_htmlspecialchars_decode($url);
				$link = utf8_strlen($url) > 55 ? utf8_substr($url, 0 , 39).' … '.utf8_substr($url, -10) : $url;
				$link = pun_htmlspecialchars($link);
				$title = ' title="'.$full_url.'"';
			}
			else
				$link = stripslashes($link);
            
            if ( substr($full_url, -4) == '.jpg'  )
                {
                return '<a href="'.$full_url.'" rel="nofollow" rel="_blank"><div style="padding:2rem;border:1px solid #6CABCD; text-align:center;">'.$full_url.'</div></a>';
                }
            elseif ( substr($full_url, -4) == '.png'  )
                {
                return '<a href="'.$full_url.'" rel="nofollow" rel="_blank"><div style="padding:2rem;border:1px solid #6CABCD; text-align:center;">'.$full_url.'</div></a>';
                }
            elseif ( substr($full_url, -4) == '.gif'  )
                {
                return '<a href="'.$full_url.'" rel="nofollow" rel="_blank"><div style="padding:2rem;border:1px solid #6CABCD; text-align:center;">'.$full_url.'</div></a>';
                }
            elseif ( substr($full_url, -4) == '.jpeg'  )
                {
                return '<a href="'.$full_url.'" rel="nofollow" rel="_blank"><div style="padding:2rem;border:1px solid #6CABCD; text-align:center;">'.$full_url.'</div></a>';
                }
            else
                {
                return '<a href="'.$full_url.'" rel="nofollow" rel="_blank"'.$title.'>'.$link.'</a>';
                }
		}
	}
	//
	// Replace string matching regular expression
	//
	// This function takes care of possibly disabled unicode properties in PCRE builds
	//
	function ucp_preg_replace($pattern, $replace, $subject, $callback = false)
	{
		if($callback) 
			$replaced = preg_replace_callback($pattern, create_function('$matches', 'return '.$replace.';'), $subject);
		else
			$replaced = preg_replace($pattern, $replace, $subject);

		// If preg_replace() returns false, this probably means unicode support is not built-in, so we need to modify the pattern a little
		if ($replaced === false)
		{
			if (is_array($pattern))
			{
				foreach ($pattern as $cur_key => $cur_pattern)
					$pattern[$cur_key] = str_replace('\p{L}\p{N}', '\w', $cur_pattern);

				$replaced = preg_replace($pattern, $replace, $subject);
			}
			else
				$replaced = preg_replace(str_replace('\p{L}\p{N}', '\w', $pattern), $replace, $subject);
		}

		return $replaced;
	}

	//
	// A wrapper for ucp_preg_replace
	//
	function ucp_preg_replace_callback($pattern, $replace, $subject)
	{
		return ucp_preg_replace($pattern, $replace, $subject, true);
	}

	//
	// Make hyperlinks clickable
	//
	function do_clickable($text)
	{
		$text = ' '.$text;
		$text = ucp_preg_replace_callback('%(?<=[\s\]\)])(<)?(\[)?(\()?([\'"]?)(https?|ftp|news){1}://([\p{L}\p{N}\-]+\.([\p{L}\p{N}\-]+\.)*[\p{L}\p{N}]+(:[0-9]+)?(/(?:[^\s\[]*[^\s.,?!\[;:-])?)?)\4(?(3)(\)))(?(2)(\]))(?(1)(>))(?![^\s]*\[/(?:url|img)\])%ui', 'stripslashes($matches[1].$matches[2].$matches[3].$matches[4]).handle_url_tag($matches[5]."://".$matches[6], $matches[5]."://".$matches[6], false).stripslashes($matches[4].$matches[10].$matches[11].$matches[12])', $text);
		$text = ucp_preg_replace_callback('%(?<=[\s\]\)])(<)?(\[)?(\()?([\'"]?)(www|ftp)\.(([\p{L}\p{N}\-]+\.)+[\p{L}\p{N}]+(:[0-9]+)?(/(?:[^\s\[]*[^\s.,?!\[;:-])?)?)\4(?(3)(\)))(?(2)(\]))(?(1)(>))(?![^\s]*\[/(?:url|img)\])%ui','stripslashes($matches[1].$matches[2].$matches[3].$matches[4]).handle_url_tag($matches[5].".".$matches[6], $matches[5].".".$matches[6], false).stripslashes($matches[4].$matches[10].$matches[11].$matches[12])', $text);

		return substr($text, 1);
	}
?>
