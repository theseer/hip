<?php
namespace theseer\hip;

class FileGlobIterator extends \GlobIterator {

    /**
     * @return File
     */
    public function current() {
        /** @var \SplFileInfo $file */
        $file = parent::current();
        return new File($file->getPathname());
    }

}
