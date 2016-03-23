<?php
namespace theseer\hip;

class Processor {

    /**
     * @var Directory
     */
    private $outputDirectory;

    /**
     * @var Importer
     */
    private $importer;

    /**
     * Processor constructor.
     *
     * @param Importer  $importer
     * @param Directory $outputDirectory
     */
    public function __construct(Importer $importer, Directory $outputDirectory) {
        $this->importer = $importer;
        $this->outputDirectory = $outputDirectory;
    }

    public function run(Directory $source, $mask) {
        foreach($source->glob($mask) as $file) {
            /** @var File $file */
            $result = $this->importer->import($file);
            $outputFile = $this->outputDirectory->file(
                $file->relativePath($source)
            );
            $outputFile->saveContents($result);
        }
    }
}
