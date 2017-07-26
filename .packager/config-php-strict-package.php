<?php

$phpFileSystemMode = Packager_Php::FS_MODE_STRICT_PACKAGE;

$config = array(
	'sourcesDir'				=> __DIR__ . '/../development',
	'releaseFile'				=> __DIR__ . '/../release/index.php',
	// do not include script or file, where it's relative path from sourceDir match any of these rules:
	'excludePatterns'			=> array(
		
		// Common excludes for every MvcCore app using composer:
		"/\.",										// Everything started with '.' (.git, .htaccess ...)
		"^/web\.config",							// Microsoft IIS .rewrite rules
		"^/Var/Logs/.*",							// App development logs
		"composer\.(json|lock)",					// composer.json and composer.lock
		"LICEN(C|S)E\.(txt|TXT|md|MD)",				// libraries licence files
		"\.(bak|BAK`bat|BAT|md|MD|phpt|PHPT)$",
		
		// Exclude specific PHP libraries
		"^/vendor/composer/.*",						// composer itself
		"^/vendor/autoload\.php",					// composer autoload file
		"^/vendor/mvccore/mvccore/src/startup\.php",// mvccore autoload file
		"^/vendor/tracy/.*",						// tracy library (https://tracy.nette.org/)
		"^/vendor/mvccore/ext-debug-tracy.*",		// mvccore tracy adapter and all tracy panel extensions
		"^/vendor/nette/safe-stream.*",				// nette safe stream used to complete assets in cache
		"^/vendor/mrclay/.*",						// HTML/JS/CSS minify library

		// Exclude source css and js files, use only what is generated in '/Var/Tmp' dir
		"^/static/js",
		"^/static/css",
		"^/static/fonts/(.*)\.css$",
	),
	// include all scripts or files, where it's relative path from sourceDir match any of these rules:
	// (include paterns always overides exclude patterns)
	'includePatterns'		=> array(
	),
	// process simple strings replacements on all readed PHP scripts before saving into result package:
	// (replacements are executed before configured minification in RAM, they don't affect anythin on hard drive)
	'stringReplacements'	=> array(
		// Switch MvcCore application back from SFU mode to automatic compile mode detection
		'MvcCore::GetInstance()->Run(1);'			=> 'MvcCore::GetInstance()->Run();',
		'$app->Run(1);'								=> '$app->Run();',
	),
	'minifyTemplates'		=> 1,// Remove non-conditional comments and whitespaces
	'minifyPhp'				=> 1,// Remove comments and whitespaces
);