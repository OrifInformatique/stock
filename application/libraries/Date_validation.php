<?php

class Date_validation {
	/*
		Fonction vérifiant qu'il s'agit d'une date valide au format AAAA-MM-JJ
		Adapté de : http://php.net/manual/en/function.checkdate.php (merci à  glavic at gmail dot com)
	*/
	public function valid_date($input)
	{
		$d = DateTime::createFromFormat('Y-m-d', $input);
		return $d && $d->format('Y-m-d') == $input; 
	}
}