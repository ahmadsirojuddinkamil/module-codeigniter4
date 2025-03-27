<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RepositorysGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-repository';
    protected $description = 'Generates a new repository. parameter 1 is the repository and parameter 2 is the module';
    protected $usage = 'module:make-repository [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the repository to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'repository';

        if (!checkCountParams($params, $type)) {
            return;
        }

        $moduleInfo = moduleFilePath($params, ucfirst($type));

        if (!checkModuleExists($moduleInfo['modulePath'], $moduleInfo['nameModule'])) {
            return;
        }

        if (!checkFolderGenerateExists($moduleInfo['modulePath'], $moduleInfo['nameModule'], ucfirst($type))) {
            return;
        }

        if (!checkFileExists($moduleInfo['modulePath'], $moduleInfo['nameFile'], ucfirst($type))) {
            return;
        }

        // CLI::write('file ada');

        $this->generateFileRepository($moduleInfo['nameFile'], $moduleInfo['filePath'], $moduleInfo['nameModule']);
    }

    private function generateFileRepository($nameFile, $filePath, $nameModule = null)
    {
        $content = contentRepository($nameFile, $nameModule);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }
    }
}
