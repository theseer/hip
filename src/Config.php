<?php
namespace theseer\hip;

class Config {

    /**
     * @var \DOMXPath
     */
    private $xp;

    /**
     * Config constructor.
     *
     * @param \DOMDocument $dom
     */
    public function __construct(\DOMDocument $dom) {
        $this->ensureCorrectDocument($dom);
        $this->xp = new \DOMXPath($dom);
        $this->xp->registerNamespace('hip', 'https://hip.netpirates.net/config');
    }

    public function getSourceDirectory() {
        return $this->toDirectory(
            $this->xp->query('//hip:source')->item(0)->getAttribute('directory')
        );
    }

    public function getSourceMask() {
        $mask = $this->xp->query('//hip:source')->item(0)->getAttribute('mask');
        if (!$mask) {
            $mask = '*.html';
        }
        return $mask;
    }

    public function getOutputDirectory() {
        return $this->toDirectory(
            $this->xp->query('//hip:output')->item(0)->getAttribute('directory')
        );
    }

    public function getAssetDirectory() {
        return $this->toDirectory(
            $this->xp->query('//hip:assets')->item(0)->getAttribute('directory')
        );
    }

    private function ensureCorrectDocument(\DOMDocument $dom) {
        if ($dom->documentElement->localName !== 'hip') {
            throw new \InvalidArgumentException('Not a hip configuration');
        }
        if ($dom->documentElement->namespaceURI !== 'https://hip.netpirates.net/config') {
            throw new \InvalidArgumentException('Not a hip configuration');
        }
    }

    /**
     * @param string $path
     *
     * @return Directory
     */
    private function toDirectory($path) {
        if (strpos('/', $path) !== 0) {
            $path = dirname($this->xp->document->documentURI) . '/' . $path;
        }
        return new Directory($path);
    }

}
