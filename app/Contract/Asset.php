<?php
namespace App\Contract;

use App\Definition\Contract;
use App\Service\Asset as AssetService;

class Asset
{
	use Contract;

	protected static function newInstance()
	{
		return new AssetService();
	}
	public static function get($identifier)
	{
		$instance = self::getInstance();
		return $instance->get($identifier);
	}
}
?>
