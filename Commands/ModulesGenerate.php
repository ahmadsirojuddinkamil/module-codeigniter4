<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModulesGenerate extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:generate';
    protected $description = 'Generates a new module folder.';
    protected $usage = 'module:generate [module_name]';

    protected $arguments = [
        'module_name' => 'The name of the module to create.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        if (empty($params) || empty($params[0])) {
            CLI::error("Nama modul harus diberikan. Contoh: php spark module:generate User");
            return;
        }

        $modulesPath = ROOTPATH . 'modules';
        $newFolder = ucfirst($params[0]);
        $fullPath = $modulesPath . DIRECTORY_SEPARATOR . $newFolder;

        if (!is_dir($modulesPath)) {
            mkdir($modulesPath);
            file_put_contents($modulesPath . '/.gitkeep', '');
            CLI::write('Folder modules berhasil dibuat.');
        }

        if (!is_dir($fullPath)) {
            if (mkdir($fullPath)) {
                file_put_contents($fullPath . '/.gitkeep', '');
                CLI::write("Folder '{$newFolder}' telah berhasil dibuat di dalam folder modules.");
                $gitkeepPath = $fullPath . DIRECTORY_SEPARATOR . '.gitkeep';
                file_put_contents($gitkeepPath, '');

                $this->registerModuleInAutoload($newFolder);
            } else {
                CLI::error("Gagal membuat folder '{$newFolder}'. Pastikan Anda memiliki izin yang cukup.");
            }
        } else {
            CLI::write("Folder '{$newFolder}' sudah ada di dalam folder modules.");
        }
    }

    private function registerModuleInAutoload($newFolder)
    {
        $autoloadFile = APPPATH . 'Config/Autoload.php';
        $autoloadContent = file_get_contents($autoloadFile);
        $search = 'public $psr4 = [';
        $newEntry = "        'Modules\\{$newFolder}' => ROOTPATH . 'modules/{$newFolder}',\n";

        if (strpos($autoloadContent, $search) !== false) {
            $lines = explode("\n", $autoloadContent);

            $psr4EndIndex = 0;
            foreach ($lines as $index => $line) {
                if (trim($line) === '];') {
                    $psr4EndIndex = $index;
                    break;
                }
            }

            array_splice($lines, $psr4EndIndex, 0, $newEntry);
            $updatedContent = implode("\n", $lines);
            file_put_contents($autoloadFile, $updatedContent);
            CLI::write("Direktori '{$newFolder}' telah ditambahkan ke Autoload.php di bawah entri lainnya.");
        } else {
            CLI::error("Gagal menemukan entry psr4 di Autoload.php.");
        }
    }
}
