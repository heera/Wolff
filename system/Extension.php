<?php

namespace System;

class Extension {

    private $folder;
    private $active;
    private $extensions;
    private $library;
    private $session;
    private $cache;
    private $upload;


    public function __construct($library, $session, $cache, $upload) {
        $this->folder = $_SERVER['DOCUMENT_ROOT'] . PROJECT_ROOT . 'extension';
        $this->extensions = [];
        $this->library = $library;
        $this->session = $session;
        $this->cache = $cache;
        $this->upload = $upload;
        $this->active = true;
    }
    

    /**
     * Load all the php files in the extension folder
     */
    public function load() {
        if (!$this->active) {
            return;
        }

        $this->makeFolder();

        $files = glob($this->folder . DIRECTORY_SEPARATOR . '*.php');

        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $class = 'Extension' . DIRECTORY_SEPARATOR . $filename;

            $extension = new $class;
            $extension->library = $this->library;
            $extension->session = $this->session;
            $extension->cache = $this->cache;
            $extension->upload = $this->upload;
            $extension->index();

            $this->extensions[] = array(
                'filename'    => $filename,
                'name'        => $extension->desc['name']?? '',
                'description' => $extension->desc['description']?? '',
                'version'     => $extension->desc['version']?? '',
                'author'      => $extension->desc['author']?? ''
            );
        }
    }


    /**
     * Check if the extension folder exists
     * @return bool true if the extension folder exists, false otherwise
     */
    public function folderExists() {
        return file_exists($this->getFolder());
    }


    /**
     * Make the extension folder directory if doesn't exists
     */
    public function makeFolder() {
        if (!$this->folderExists()) {
            mkdir($this->folder);
        }
    }


    /**
     * Get the extension folder directory
     * @return string the extension folder directory
     */
    public function getFolder() {
        return $this->folder;
    }


    /**
     * Activate the extension system
     * @param bool the extension state
     */
    public function activate(bool $active = true) {
        $this->active = $active;
    }


    /**
     * Get the extensions list
     * @param string the extensions filename
     * @return array the extensions list if the name is empty or the specified extension otherwise
     */
    public function get(string $name = '') {
        if (empty($name)) {
            return $this->extensions;
        }
        
        foreach($this->extensions as $extension) {
            if ($extension['filename'] == $name) {
                return $extension;
            }
        }
    }
}