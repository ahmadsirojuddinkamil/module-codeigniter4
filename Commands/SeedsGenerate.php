<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class SeedsGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-seeder';
    protected $description = 'Generates a new seeder. parameter 1 is Name seeder and parameter 2 is the module';
    protected $usage = 'module:make-seeder [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the seeder to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'database';
        $subType = 'Seeds';

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

        if (!checkSubFolderGenerateExists($moduleInfo['modulePath'], $moduleInfo['nameModule'], ucfirst($type), ucfirst($subType))) {
            return;
        }

        if (!checkFileExists($moduleInfo['modulePath'], $moduleInfo['nameFile'], ucfirst($type), ucfirst($subType))) {
            return;
        }

        $this->generateFileSeeder($moduleInfo['nameFile'], $moduleInfo['filePath'], ucfirst($subType), $moduleInfo['nameModule']);
    }

    private function generateFileSeeder($nameFile, $filePath, $subType, $nameModule = null)
    {
        $filePath = str_replace('Database/', "Database/$subType/", $filePath);

        $content = contentSeeder($nameModule);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }
    }
}
