<?php

namespace Core;

class Extension
{

    /**
     * List of extensions
     *
     * @var array
     */
    private static $extensions;


    const CLASS_ERROR = "Warning: Extension class %s doesn't exists";
    const NAMESPACE = 'Extension\\';
    const FILE = 'system/Definitions/Extensions.php';


    /**
     * Load all the extensions files that matches the current route
     *
     * @param  string  $type  the type of extensions to load
     * @param  mixed  $loader  the loader class
     *
     * @return bool true if the extensions have been loaded, false otherwise
     */
    public static function load(string $type, $loader = null)
    {
        if (!extensionsEnabled() || empty(self::$extensions)) {
            return false;
        }

        self::makeFolder();

        foreach (self::$extensions as $extension) {
            if ($extension['type'] !== $type || !self::matchesRoute($extension['route'])) {
                continue;
            }

            $class = self::NAMESPACE . $extension['name'];

            if (!class_exists($class)) {
                error_log(sprintf(self::CLASS_ERROR, $extension['name']));
                continue;
            }

            $extension = new $class;
            $extension->load = $loader;
            $extension->session = $loader->getSession();
            $extension->upload = $loader->getUpload();
            $extension->index();
        }

        return true;
    }


    /**
     * Returns true if the directory matches the current url, false otherwise
     *
     * @param  string  $dir  the directory
     *
     * @return bool true if the directory matches the current url, false otherwise
     */
    private static function matchesRoute(string $dir)
    {
        if (empty($dir)) {
            return false;
        }

        $dir = explode('/', Str::sanitizeURL($dir));
        $dirLength = count($dir) - 1;

        $url = explode('/', Str::sanitizeURL(getCurrentPage()));
        $urlLength = count($url) - 1;

        for ($i = 0; $i <= $dirLength && $i <= $urlLength; $i++) {
            if ($dir[$i] === '*') {
                return true;
            }

            if ($url[$i] != $dir[$i] && !empty($dir[$i]) && !Route::isGetVariable($dir[$i])) {
                return false;
            }

            //Finish if last GET variable from url is empty
            if ($i + 1 === $dirLength && $i === $urlLength && Route::isGetVariable($dir[$i + 1])) {
                return true;
            }

            //Finish if in the end of the route
            if ($i === $dirLength && $i === $urlLength) {
                return true;
            }
        }

        return false;
    }


    /**
     * Returns true if the extension folder exists, false otherwise
     * @return bool true if the extension folder exists, false otherwise
     */
    public static function folderExists()
    {
        return file_exists(getServerRoot() . getExtensionDirectory());
    }


    /**
     * Make the extension folder directory if it doesn't exists
     */
    public static function makeFolder()
    {
        if (!self::folderExists()) {
            mkdir(getServerRoot() . getExtensionDirectory());
        }
    }


    /**
     * Add an extension of type after
     *
     * @param  string  $route  the desired route where it will work
     * @param  string  $extension_name  the extension name
     */
    public static function after(string $route, string $extension_name)
    {
        self::$extensions[] = array(
            'name'  => $extension_name,
            'route' => $route,
            'type'  => 'after'
        );
    }


    /**
     * Add an extension of type before
     *
     * @param  string  $route  the desired route where it will work
     * @param  string  $extension_name  the extension name
     */
    public static function before(string $route, string $extension_name)
    {
        self::$extensions[] = array(
            'name'  => $extension_name,
            'route' => $route,
            'type'  => 'before'
        );
    }


    /**
     * Get the extensions list
     *
     * @param  string the extensions filename
     *
     * @return array the extensions list if the name is empty or the specified extension otherwise
     */
    public static function get(string $name = '')
    {
        //Specified extension
        if (!empty($name)) {
            $class = self::NAMESPACE . $name;

            if (class_exists($class)) {
                return (new $class)->desc;
            }

            return false;
        }

        //All the extensions
        $files = glob(getExtensionDirectory() . '*.php');
        $extensions = [];

        foreach ($files as $file) {
            $filename  = basename($file, '.php');
            $class = self::NAMESPACE . $filename;
            $extension = new $class;

            $extensions[] = array(
                'name'        => $extension->desc['name'] ?? '',
                'description' => $extension->desc['description'] ?? '',
                'version'     => $extension->desc['version'] ?? '',
                'author'      => $extension->desc['author'] ?? '',
                'filename'    => $filename
            );
        }

        return $extensions;
    }
}