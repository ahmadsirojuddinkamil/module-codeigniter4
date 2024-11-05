<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class RoutesGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-route';
    protected $description = 'Generates a new route. parameter 1 is the route and parameter 2 is the module';
    protected $usage = 'module:make-route [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the route to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        $type = 'routes';

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

        $this->generateFileRoute($moduleInfo['nameModule'], $moduleInfo['nameFile'], $moduleInfo['filePath']);
    }

    private function generateFileRoute($nameModule, $nameFile, $filePath)
    {
        $content = contentRoute();
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }

        if (!registerRoute($nameModule, $nameFile)) {
            return;
        }
    }
}
