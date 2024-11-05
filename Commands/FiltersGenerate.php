<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class FiltersGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-filter';
    protected $description = 'Generates a new filter. parameter 1 is the filter and parameter 2 is the module';
    protected $usage = 'module:make-filter [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the filter to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        $type = 'filters';

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

        $this->generateFileFilter($moduleInfo['nameFile'], $moduleInfo['nameModule'], $moduleInfo['filePath']);
    }

    private function generateFileFilter($nameFile, $nameModule, $filePath)
    {
        $content = contentFilter($nameModule, $nameFile);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }

        if (!registerFilter($nameModule, $nameFile)) {
            return;
        }
    }
}
