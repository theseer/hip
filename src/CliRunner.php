<?php
namespace theseer\hip;

class CliRunner {

    const RC_OK = 0;
    const RC_ERROR = 1;

    /**
     * @var Version
     */
    private $version;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * CliRunner constructor.
     *
     * @param Version $version
     * @param Factory $factory
     */
    public function __construct(Version $version, Factory $factory) {
        $this->version = $version;
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function run(Request $request) {
        try {
            if ($request->isHelpRequest()) {
                $this->showHelp($request->getExecutable());
                return self::RC_OK;
            } else if ($request->isVersionRequest()) {
                $this->showVersion();
                return self::RC_OK;
            }
            $config = $this->loadConfig($request->getPathToConfigFile());
            return $this->process($config);
        } catch (\Exception $e) {
            $this->showVersion();
            fwrite(STDERR, $e->getMessage() . "\n\n");
            return self::RC_ERROR;
        } catch (\Throwable $t) {
            $this->showVersion();
            fwrite(STDERR, $t->getMessage() . "\n\n");
            return self::RC_ERROR;
        }
    }

    private function process(Config $config) {
        $processor = new Processor(
            new Importer($config->getAssetDirectory()),
            new Directory($config->getOutputDirectory())
        );
        $processor->run($config->getSourceDirectory(), $config->getSourceMask());
        return self::RC_OK;
    }


    private function showHelp($executable) {
        $this->showVersion();
        printf("
Usage: %s <path/to/hip.xml>
            
  -h, --help     This help output
  -v, --version  Show version and exit
\n", $executable
        );
    }

    private function showVersion() {
        echo $this->version->asCopyrightString() . "\n\n";
    }

    private function loadConfig(Directory $pathToConfigFile) {
        $configFile = $pathToConfigFile->file(new File('hip.xml'));
        if (!$configFile->exits()) {
            throw new \InvalidArgumentException(
                sprintf('Config file "%s" not found.', (string)$configFile)
            );
        }

        $dom = new \DOMDocument();
        $dom->load( (string)$configFile );
        return new Config($dom);
    }
}
