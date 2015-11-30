<?php

class Sql
{
	public static function generateRequest($arguments, $currentArgument)
	{
		$request = $arguments[$currentArgument];
		$currentArgument++;
		
		$position = 0;
		while (count($arguments) > $currentArgument && (($position = @strpos($request, '?', $position)) !== false))
		{
			$argument = $arguments[$currentArgument];
			$currentArgument++;
			
			if (is_string($argument))
				$argument = Sql::rc()->quote($argument);
			
			$request = substr_replace($request, $argument, $position, 1);
			$position += strlen($argument);
		}
		return $request;
	}
	
	public static function request()
	{
		$arguments = func_get_args();
		
		$request = '';
		$request .= Sql::generateRequest($arguments, 0);
		
		$GLOBALS['queries'][] = Sql::rc()->query($request);
		$GLOBALS['lastSelectId'] = count($GLOBALS['queries']) - 1;
		return count($GLOBALS['queries']) - 1;
	}
	
	public static function rc()
	{
		return $GLOBALS['db'];
	}
	
	public static function getData($queryId = -1)
	{
		if ($queryId == -1)
			$queryId = $GLOBALS['lastSelectId'];
		return $GLOBALS['queries'][$queryId]->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function init($host = 'localhost', $database = 'triton', $login = 'triton', $pass = '')
	{
		$bdd = new PDO("mysql:host=" .$host.";dbname=" .$database."", "".$login."", "".$pass."");
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		$bdd->query("SET NAMES 'utf8'");
		$GLOBALS['db'] = $bdd;
	}
}
Sql::init("localhost","hackathon","hacker","hacker");

?>