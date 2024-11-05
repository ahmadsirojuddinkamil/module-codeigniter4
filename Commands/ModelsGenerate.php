<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class ModelsGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-model';
    protected $description = 'Generates a new model. parameter 1 is the model and parameter 2 is the module';
    protected $usage = 'module:make-model [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the model to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'models';

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

        $this->generateFileModel($moduleInfo['nameFile'], $moduleInfo['filePath'], $moduleInfo['nameModule']);
    }

    private function generateFileModel($nameFile, $filePath, $nameModule = null)
    {
        $content = contentModel($nameFile, $nameModule);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }
    }
}
