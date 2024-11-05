<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class LibrariesGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-libraries';
    protected $description = 'Generates a new libraries. parameter 1 is Module.';
    protected $usage = 'module:make-libraries [module_name]';

    protected $arguments = [
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        if (count($params) !== 1) {
            CLI::error("Command make libraries tidak valid!");
            return false;
        }

        $nameModule = ucfirst($params[0]);
        $pathModule = ROOTPATH . 'modules/' . $nameModule;
        $pathLibraries = $pathModule . '/Libraries';

        if (!is_dir($pathModule)) {
            CLI::error("Module $nameModule tidak ada!");
            return;
        }

        if (!is_dir($pathLibraries)) {
            mkdir($pathLibraries);
            file_put_contents($pathLibraries . '/.gitkeep', '');
            CLI::write("Folder Libraries di Module $nameModule berhasil dibuat!");
            return;
        }

        CLI::error("Folder Libraries di Module $nameModule sudah pernah dibuat!");
        return;
    }
}
