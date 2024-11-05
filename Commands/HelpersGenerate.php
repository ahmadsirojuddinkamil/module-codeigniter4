<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class HelpersGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-helper';
    protected $description = 'Generates a new helper. parameter 1 is Helpers and parameter 2 is the module';
    protected $usage = 'module:make-helper [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the helper to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'helpers';

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
    }
}
