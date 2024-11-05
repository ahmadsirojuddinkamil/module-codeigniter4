<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ConfigGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-config';
    protected $description = 'Generates a new config. parameter 1 is Module.';
    protected $usage = 'module:make-config [module_name]';

    protected $arguments = [
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        if (count($params) !== 1) {
            CLI::error("Command make config tidak valid!");
            return false;
        }

        $nameModule = ucfirst($params[0]);
        $pathModule = ROOTPATH . 'modules/' . $nameModule;
        $pathConfig = $pathModule . '/Config';

        if (!is_dir($pathModule)) {
            CLI::error("Module $nameModule tidak ada!");
            return;
        }

        if (!is_dir($pathConfig)) {
            mkdir($pathConfig);
            file_put_contents($pathConfig . '/.gitkeep', '');
            CLI::write("Folder Config di Module $nameModule berhasil dibuat!");
            return;
        }

        CLI::error("Folder Config di Module $nameModule sudah pernah dibuat!");
        return;
    }
}
