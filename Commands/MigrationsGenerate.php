<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class MigrationsGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-migration';
    protected $description = 'Generates a new migration. parameter 1 is Name migration and parameter 2 is the module';
    protected $usage = 'module:make-migration [directory_name] [module_name]';

    protected $arguments = [
        'directory_name' => 'The name of the migration to create.',
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');
        $type = 'database';
        $subType = 'migrations';

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

        $nameMigrations = date('Y-m-d-His') . "_{$moduleInfo['nameFile']}";

        if (!checkFileExists($moduleInfo['modulePath'], $nameMigrations, ucfirst($type), ucfirst($subType))) {
            return;
        }

        $this->generateFileMigration($nameMigrations, $moduleInfo['filePath'], ucfirst($subType), $moduleInfo['nameModule']);
    }

    private function generateFileMigration($nameFile, $filePath, $subType, $nameModule = null)
    {
        $filePath = str_replace('Database/', "Database/$subType/", $filePath);
        $filePath = implode('/', array_slice(explode('/', $filePath), 0, -1)) . "/$nameFile";

        $content = contentMigration($nameModule);
        makeDirFileGenerate($filePath);

        if (!moveFileGenerate($filePath, $content, $nameFile)) {
            return;
        }
    }
}
