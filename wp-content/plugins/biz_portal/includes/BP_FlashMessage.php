<?php
/**
 * FlashMessage
 *
 * Create and persist message in the session.
 * @version 1.0
 * @author muneer<muneer@live.it> 
 * @copyright Swiss Bureau Proj. Supply (20/07/2014)
 * @todo add warning message
 */
class BP_FlashMessage
{
	const ERROR = 1;
	const SUCCESS = 2;
	const INFO = 3;

	public static function HasMessages($type = NULL)
	{
		if ($type == NULL) {
			if (isset($_SESSION['flash_message_' . self::ERROR])
				|| isset($_SESSION['flash_message_' . self::SUCCESS])
				|| isset($_SESSION['flash_message_' . self::INFO]))
			{
				return TRUE;
			}
		}
		else {
			if (isset($_SESSION['flash_message_' . $type])) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function Add($message, $type = self::INFO)
	{		
		if (!isset($_SESSION['flash_message_' . $type]))
        $_SESSION['flash_message_' . $type] = array();	 

	    if (is_array($message))
	        $_SESSION['flash_message_' . $type] = array_merge($_SESSION['flash_message_' . $type], $message);
	    else
	        $_SESSION['flash_message_' . $type][] = $message;
	}

	public static function Get($type, $unset = TRUE)
	{
		if (isset($_SESSION['flash_message_' . $type]))
	    {
	        $message =  $_SESSION['flash_message_' . $type];
	        if ($unset)
	            unset($_SESSION['flash_message_' . $type]);
	        return $message;
	    }
	    else
	    {
	        return array();
	    }
	}
}