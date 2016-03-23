<?php
namespace theseer\hip;

class Factory {

    public function createCliRunner() {
        return new CliRunner(new Version, $this);
    }

    private function createProcessor() {
        return new Processor($this->createImporter());
    }

    private function createImporter() {
        return new Importer();
    }
}
