<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RoutesList extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'module:route-list';
    protected $description = 'List of routes in modules. parameter 1 is the module';
    protected $usage = 'module:route-list [module_name]';

    protected $arguments = [
        'module_name' => 'The name of the module to find.',
    ];

    protected $options = [];

    public function run(array $params)
    {
        helper('module_helper');

        if (count($params) !== 1) {
            CLI::error("Command route list tidak valid!");
            return false;
        }

        $nameModule = ucfirst($params[0]);
        $pathModule = ROOTPATH . 'modules/' . $nameModule;

        if (!is_dir($pathModule)) {
            CLI::error("Module $nameModule tidak ada!");
            return;
        }

        if (!is_dir($pathModule . '/Routes')) {
            CLI::error("Folder Route di Module $nameModule tidak ada!");
            return;
        }

        $fileRoute = $pathModule . '/Routes/Api' . $nameModule . '.php';

        if (!is_file($fileRoute)) {
            CLI::error("File api route module $nameModule tidak ada!");
            return false;
        }

        $routeContent = file_get_contents($fileRoute);

        preg_match_all('/\$routes->(get|post|put|delete|patch)\(\'([^\']+)\'\s*,\s*\[([^\]]+)\]\);/', $routeContent, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            CLI::write("Tidak ada route yang ditemukan di module $nameModule.");
            return;
        }

        $routesTable = [];
        foreach ($matches as $match) {
            $method = strtoupper($match[1]);
            $path = $match[2];
            $handler = trim($match[3]);

            $routesTable[] = [
                'Method' => $method,
                'Path' => $path,
                'Handler' => $handler,
            ];
        }

        CLI::table($routesTable, ['Method', 'Path', 'Handler']);
    }
}
