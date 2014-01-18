<?php

// Direction du cache.php
$cache_directory = 'vendor/cache.php';

include_once $cache_directory; // include > require car le cache n'existe pas forcement

// map de dossiers qui seront parcourus pour inclusion
$autoload_map = array(
    'Coffee' => 'vendor/Coffee',
    'Soda' => 'vendor/Soda',
);

spl_autoload_register(function ($className) {
    global $cache_directory, $autoload_map, $cache_map;

    // matte dans le cache map, optimise sans foreach =D
    if(!empty($cache_map) && array_key_exists($className, $cache_map)) {
    	include_once $cache_map[$className];
    	return;
    }

    // matte dans la map du dessus + ajout en cache, optimise sans foreach =D
    if (!empty($autoload_map)) {
        $nameFolder = substr($className, 0, strrpos($className, '\\'));
        if(array_key_exists($nameFolder, $autoload_map)) {
            ScanDirectory($autoload_map[$nameFolder], $className);
            return;
        }
    }

    // loader si rien trouve + ajout en cache
    loader($className);
    return;
});

// Fonction d'ajout d'un fichier dans le cache
function addFileRoadToCache($className, $fileRoad) {
    global $cache_directory, $autoload_map, $cache_map;

    // Methode avec var_export
    if (!$cache_map) {
        $cache_map = array();
    }
    $cache_map[$className] = $fileRoad;
    file_put_contents($cache_directory, '<?php' . "\n" . '$cache_map = ' . var_export($cache_map, true) . ';');

    // Methode en string
    // $cache_content = file_get_contents($cache_directory);
    // if(!$cache_content) {
    // 	$cache_content = '<?php' . "\n" . '$cache_map = array();' . "\n";
    // }
    // $cache_content .= '$cache_map["' . $className . '"] = "' . $fileRoad . '";' . "\n";
    // file_put_contents($cache_directory, $cache_content);
    return;
}

// Fonction de parcourt de dossier
function ScanDirectory($folderRoad, $className) {
    $directory = opendir($folderRoad) or die('Erreur lors de l\'ouverture du dossier') . $folderRoad;
    while ($entry = readdir($directory)) {
        if (is_dir($folderRoad . '/' . $entry) && $entry != '.' && $entry != '..') {
            ScanDirectory($folderRoad . '/' . $entry, $className);
        } else if(substr($entry, -4) == '.php') {
            loader($className);
        }
    }
    closedir($directory);
    return;
}

// Fonction de chargement d'un fichier
function loader($className) {
    $classNameSave = $className;
    $className = ltrim($className, '\\');
    $fileRoad = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileRoad = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileRoad .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    addFileRoadToCache($classNameSave, $fileRoad);
    include_once $fileRoad;
}


