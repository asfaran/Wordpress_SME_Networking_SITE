<?php

class BP_Hydrator
{
	/**
	 * Hydrate array to the object and return it
	 *
	 * @param Object $object
	 * @param array $data_array
	 * @param string $a_prefix Prefix that is already fixed witht the data key in $data_array
	 */
	public static function hydrate($object, array $data_array, $a_prefix = NULL)
	{
		foreach ($data_array as $key => $data)
		{
			if (is_null($a_prefix)) {
				if (property_exists($object, $key)) {
					$object->$key = $data;
				}
			}
			else if ((strlen($key) > strlen($a_prefix)) 
				&& (strpos($key, $a_prefix) > -1)) 
			{
				$property = substr($key, strlen($a_prefix));
				if (property_exists($object, $property)) {
					$object->$property = $data;
				}
			}
		}
		return $object;
	}
}