<?php
use PHPUnit\Framework\TestCase;

class AssetTest extends TestCase
{
	public function setUp()
	{
		mkdir(root() . '/public');
		mkdir(root() . '/public/css');
		config('locations.public', root() . '/public');
		file_put_contents(root() . '/public/css/style.css', 'body {color: black;}');
	}
	public function tearDown()
	{
		unlink(root() . '/public/css/style.css');
		rmdir(root() . '/public/css');
		rmdir(root() . '/public');
	}
	
	public function testAsset()
	{
		$this->assertEquals(asset('style.css'), '/css/style.css');
	}
}
?>