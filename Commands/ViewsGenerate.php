<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ViewsGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-view';
    protected $description = 'Generates a new view. parameter 1 is Views and parameter 2 is the module';
    protected $usage = 'module:make-view [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the view to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'views';

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

        $this->generateView($moduleInfo['modulePath']);
    }

    private function generateView($pathViews)
    {
        subFolderViewsGenerate($pathViews);
        CLI::write("Folder Views dan sub folder nya berhasil dibuat.");
    }
}
