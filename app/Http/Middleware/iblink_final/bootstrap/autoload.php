<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

if (file_exists($compiledPath = __DIR__.'/../vendor/compiled.php'))
{
	require $compiledPath;
}
elseif (file_exists($compiledPath = __DIR__.'/../storage/framework/compiled.php'))
{
	require $compiledPath;
}
