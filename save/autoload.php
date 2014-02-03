<?php

// Directions
$cache_directory = __DIR__ . DIRECTORY_SEPARATOR . 'cache/cache.php';
$main_directory = __DIR__;

include_once $cache_directory; // include > require car le cache n'existe pas forcement

// map de dossiers qui seront parcourus pour inclusion
$autoload_map = array();

spl_autoload_register(function ($className) {
    global $autoload_map, $cache_map;

    // matte dans le cache map, optimise sans foreach =D
    /** if(!empty($cache_map) && array_key_exists($className, $cache_map)) {
    	include_once $cache_map[$className];
    	return;
    }*/

    // matte dans la map du dessus + ajout en cache, optimise sans foreach =D
    if (!empty($autoload_map)) {
        if(array_key_exists($className, $autoload_map)) {
            addFileRoadToCache($className, $autoload_map[$className]);
            include_once $autoload_map[$className];
            return;
        }
    }

    // loader si rien trouve + ajout en cache
    loader($className);
    return;
});

// Fonction d'ajout d'un fichier dans le cache
function addFileRoadToCache($className, $fileRoad) {
    global $cache_directory, $cache_map;

    // Methode avec var_export
    if (!$cache_map) {
        $cache_map = array();
    }
    $cache_map[$className] = $fileRoad;
    file_put_contents($cache_directory, '<?php' . "\n" . '$cache_map = ' . var_export($cache_map, true) . ';');
    return;
}

// Fonction de parcourt de dossier
function searchFile($directory, $file, $classNameSave) {
    $open_directory = opendir($directory) or die('Erreur lors de l\'ouverture du dossier') . $directory;
    while ($entry = readdir($open_directory)) {
        if (is_dir($directory . DIRECTORY_SEPARATOR . $entry) && $entry != '.' && $entry != '..') {
            searchFile($directory . DIRECTORY_SEPARATOR . $entry, $file, $classNameSave);
        }
        elseif($entry === $file) {
            closedir($open_directory);
            $path = $directory . DIRECTORY_SEPARATOR . $file;
            addFileRoadToCache($classNameSave, $path);
            include_once $path;
            return $path;
        }
    }
    closedir($open_directory);
    return;
}

// Fonction de chargement d'un fichier
function loader($className) {
    global $main_directory;

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
    if(strrpos($fileRoad, DIRECTORY_SEPARATOR)) {
        $fileRoad = substr($fileRoad, strrpos($fileRoad, DIRECTORY_SEPARATOR) + 1);
    }
    $path = searchFile($main_directory, $fileRoad, $classNameSave);
    return;
}