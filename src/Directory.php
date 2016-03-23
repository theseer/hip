<?php
namespace theseer\hip;

class Directory {

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path) {
        $this->ensureIsDirectory($path);
        $this->path = $path;
    }

    /**
     * @param $mask
     *
     * @return \GlobIterator
     */
    public function glob($mask) {
        return new FileGlobIterator($this->path . '/' . $mask);
    }

    public function file(File $file) {
        return new File($this->path . '/' . $file->getName());
    }
    /**
     * @return string
     */
    public function asString() {
        return $this->path;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->asString();
    }

    /**
     * @param $path
     *
     * @throws \InvalidArgumentException
     */
    private function ensureIsDirectory($path) {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a directory', $path)
            );
        }
    }

}
