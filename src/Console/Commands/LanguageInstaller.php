<?php
namespace Ablunier\Laravel\Translation\Console\Commands;

use Illuminate\Console\Command;
use Ablunier\Laravel\Translation\Services\ResourcesRepository;

class LanguageInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:install {lang? : The Name of language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laravel language translations';

    /**
     * @var ResourcesRepository
     */
    protected $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        parent::__construct();

        $this->resourcesRepository = $resourcesRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $versions = $this->resourcesRepository->getVersions();
        $lang = $this->argument('lang');

        if ($lang=="") {
            foreach (config('lang-installer.languages') as $lang) {
                $this->installLang($lang, $versions);
            }

            $this->info('All language files installed correctly.'.PHP_EOL);
        }
        else {
            $this->installLang($lang, $versions);

            $this->info(sprintf('Language %s files installed correctly.', $lang).PHP_EOL);
        }
    }

    protected function installLang($lang, $versions)
    {
        $this->info(sprintf('Retrieving files for [%s] language...', $lang).PHP_EOL);

        $langPath = $this->getLangResourcesPath().DIRECTORY_SEPARATOR.$lang;

        if (! is_dir($langPath)) {
            mkdir($langPath, 0755, true);
        }

        foreach (config('lang-installer.files') as $file) {
            $this->info(sprintf('Retrieving content for [%s] translations file...', $file).PHP_EOL);

            $fileContent = $this->resourcesRepository->findForVersion($versions[$this->resourcesRepository->getLatestVersion()], $lang, $file);

            if (empty($fileContent)) {
                continue;
            }

            $filename = $langPath.DIRECTORY_SEPARATOR.$file.'.php';

            if (! file_exists($filename)) {
                file_put_contents($filename, $fileContent);
            }
        }
    }

    protected function getLangResourcesPath()
    {
        return app()->basePath().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang';
    }
}
