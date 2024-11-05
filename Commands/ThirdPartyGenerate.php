<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ThirdPartyGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:make-third-party';
    protected $description = 'Generates a new third party. parameter 1 is Module.';
    protected $usage = 'module:make-third-party [module_name]';

    protected $arguments = [
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        if (count($params) !== 1) {
            CLI::error("Command make third party tidak valid!");
            return false;
        }

        $nameModule = ucfirst($params[0]);
        $pathModule = ROOTPATH . 'modules/' . $nameModule;
        $pathThirdParty = $pathModule . '/ThirdParty';

        if (!is_dir($pathModule)) {
            CLI::error("Module $nameModule tidak ada!");
            return;
        }

        if (!is_dir($pathThirdParty)) {
            mkdir($pathThirdParty);
            file_put_contents($pathThirdParty . '/.gitkeep', '');
            CLI::write("Folder ThirdParty di Module $nameModule berhasil dibuat!");
            return;
        }

        CLI::error("Folder ThirdParty di Module $nameModule sudah pernah dibuat!");
        return;
    }
}
