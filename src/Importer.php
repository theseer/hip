<?php
namespace theseer\hip;

use watoki\dom\Parser;
use watoki\dom\Printer;
use watoki\dom\Text;

class Importer extends Printer {

    /**
     * @var string
     */
    private $basedir;

    /**
     * @param string $basedir
     */
    public function __construct($basedir) {
        $this->basedir = $basedir;
    }
    
    public function import(File $file) {
        $parser = new Parser($file->getContents());
        return $this->printNodes($parser->getNodes());
    }

    public function printNode(\watoki\dom\Node $node) {
        if ($node instanceof Text && strpos($node->getText(), '<?import')===0) {
            return $this->localProcess($node);
        }
        return parent::printNode($node);
    }

    private function localProcess(Text $node) {
        /* $text == '<?import 'filename.ext' ?>'; */
        $content = substr(trim($node->getText()), 8, -2);
        $filename = trim($content, '\' "');

        $parser = new Parser(file_get_contents($this->basedir . '/' . $filename));
        return $this->printNodes($parser->getNodes());
    }
}
