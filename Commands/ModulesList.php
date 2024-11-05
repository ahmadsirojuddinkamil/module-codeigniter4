<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModulesList extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:list';
    protected $description = 'List all available modules in the modules directory.';
    protected $usage = 'module:list';

    public function run(array $params)
    {
        $modulesPath = ROOTPATH . 'modules';

        // Periksa apakah folder 'modules' ada
        if (!is_dir($modulesPath)) {
            CLI::error("Folder 'modules' tidak ditemukan.");
            return;
        }

        // Ambil semua subfolder di dalam 'modules'
        $modules = array_filter(glob($modulesPath . '/*'), 'is_dir');

        // Cek apakah ada modul
        if (empty($modules)) {
            CLI::write("Tidak ada modul yang ditemukan.", 'yellow');
            return;
        }

        // Tampilkan daftar modul
        CLI::write("Daftar modul yang tersedia:", 'green');
        foreach ($modules as $module) {
            CLI::write("- " . basename($module));
        }
    }
}
