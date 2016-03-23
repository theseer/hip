<?php
namespace theseer\hip;

class File {

    /**
     * @var string
     */
    private $name;

    /**
     * File constructor.
     *
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getContents() {
        return file_get_contents($this->name);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

    public function relativePath(Directory $directory) {
        if (strpos($this->name, $directory->asString()) !== 0) {
            throw new \InvalidArgumentException('File not within given directory path');
        }
        return new File(substr($this->name, strlen($directory->asString())));
    }

    public function saveContents($result) {
        file_put_contents($this->name, $result);
    }

    public function exits() {
        return file_exists($this->name);
    }

}
