<?php
namespace theseer\hip;

class Request {

    /**
     * @var array
     */
    private $argv;

    /**
     * @param array $argv
     */
    public function __construct(array $argv) {
        $this->argv = $argv;
    }

    public function isVersionRequest() {
        return in_array('-v', $this->argv, true) || in_array('--version', $this->argv, true);
    }

    public function isHelpRequest() {
        return in_array('-h', $this->argv, true) || in_array('--help', $this->argv, true);
    }

    public function getExecutable() {
        return $this->argv[0];
    }

    public function getPathToConfigFile() {
        if (count($this->argv) === 1) {
            return new Directory('.');
        }
        return new Directory($this->argv[1]);
    }

}
