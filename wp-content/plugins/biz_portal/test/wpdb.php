<?php

interface wpdb
{
	function query($string);
	function insert($table, $data, $format);
}