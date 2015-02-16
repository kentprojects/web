<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
final class Intents
{
	/**
	 * @var array
	 */
	protected static $defaults = array(
		"request_page_title" => "Ask someone to let you something?",
		"request_page_description" => "Someone will be asked if you can do the thing.",
		"request_page_confirm" => "Yes, please",
		"request_page_deny" => "Actually, no",
		"view_page_title" => "Someone would like to something!",
		"view_page_description" => "If you let them something, then something will happen. If you don't let them something, something else will happen.",
		"view_page_confirm" => "Accept",
		"view_page_deny" => "Deny"
	);
	/**
	 * @var array
	 */
	protected static $intents = array(
		"join_a_group" => array(
			"request_page_title" => "Ask someone to let you join their group?"
		)
	);

	/**
	 * @param string $intent
	 * @return array
	 */
	public static function getValuesForAPage($intent)
	{
		return array_merge(
			static::$defaults, array_key_exists($intent, static::$intents) ? static::$intents[$intent] : array()
		);
	}

	public static function isValidIntent($intent)
	{
		return array_key_exists($intent, static::$intents);
	}
}