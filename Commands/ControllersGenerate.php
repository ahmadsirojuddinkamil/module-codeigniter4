<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class ControllersGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-controller';
    protected $description = 'Generates a new controller. parameter 1 is the controller and parameter 2 is the module';
    protected $usage = 'module:make-controller [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the controller to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        $type = 'controllers';

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

        $this->generateFileController($moduleInfo['nameFile'], $moduleInfo['nameModule'], $moduleInfo['filePath']);
    }

    private function generateFileController($nameFile, $nameModule, $filePath)
    {
        $content = contentController($nameModule, $nameFile);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }
    }
}
