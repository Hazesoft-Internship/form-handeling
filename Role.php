<?php

require_once 'Management.php';

class Role extends Management
{
	protected static $role = "Super Admin";

	protected static string $name = "Role";

	public function __construct(
		// protected string $name,
	) {
		// $this->name = $name;
		echo "<h1>Hello from Role class</h1>";
	}

	public function index(): string
	{
		return "Role Index";
	}

	public function getRole(): string
	{
		return self::$role;
	}

	public static function getManagementName(): string
	{
		$name = static::$name;

		return "Management {$name}";
		// echo "Role Management";
		// die;
		// return $this->name . 'Role Management';
	}
	
	// public function __get($name)
	// {
	// 	echo "Property {$name} does not exist";
	// 	die;
	// 	$adminRole = static::$role;
	// 	return "Property {$adminRole}  does not exist";
	// }

	// public function __call(string $method, array $parms)
	// {
	// 	echo "Method {$method} does not exist";
	// 	die;
	// 	return "nameFunctionCalled";
	// }
}

echo "<br>";
