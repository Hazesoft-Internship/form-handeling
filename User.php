<?php

class User
{
	public function __construct()
	{
		echo "<h1>Hello from user class</h1>";
	}

	public function index(): string
	{
		return "<h1>User Index</h1>";
	}
}

// new User();
echo "<br>";