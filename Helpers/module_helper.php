<?php

use CodeIgniter\CLI\CLI;

if (!function_exists('checkCountParams')) {
    function checkCountParams($params, $type)
    {
        if (count($params) !== 2) {
            CLI::error("Command module $type tidak valid!");
            return false;
        }

        return true;
    }
}

if (!function_exists('moduleFilePath')) {
    function moduleFilePath($params, $type)
    {
        $nameModule = ucfirst($params[1]);
        $modulePath = ROOTPATH . 'modules' . DIRECTORY_SEPARATOR . $nameModule;

        $nameFile = ucfirst($params[0]);
        $filePath = $modulePath . DIRECTORY_SEPARATOR . $type . '/' . $nameFile;

        return [
            'nameModule' => $nameModule,
            'modulePath' => $modulePath,
            'nameFile' => $nameFile,
            'filePath' => $filePath,
        ];
    }
}

if (!function_exists('checkModuleExists')) {
    function checkModuleExists($modulePath, $nameModule)
    {
        if (!is_dir($modulePath)) {
            CLI::error("Module {$nameModule} tidak ditemukan!");
            return false;
        }

        return true;
    }
}

if (!function_exists('checkFolderGenerateExists')) {
    function checkFolderGenerateExists($modulePath, $nameModule, $nameFolder)
    {
        $path = $modulePath . DIRECTORY_SEPARATOR . $nameFolder;

        if (!is_dir($path)) {
            if (mkdir($path)) {
                file_put_contents($path . '/.gitkeep', '');
                CLI::write("Folder $nameFolder telah berhasil dibuat di dalam folder modules {$nameModule}.");
            } else {
                CLI::error("Gagal membuat folder! Pastikan Anda memiliki izin yang cukup.");
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('checkSubFolderGenerateExists')) {
    function checkSubFolderGenerateExists($modulePath, $nameModule, $nameFolder, $nameSubFolder = null)
    {
        $path = $modulePath . DIRECTORY_SEPARATOR . $nameFolder;

        if ($nameSubFolder) {
            $path = $modulePath . DIRECTORY_SEPARATOR . $nameFolder . '/' . $nameSubFolder;
        }

        if (!is_dir($path)) {
            if (mkdir($path)) {
                file_put_contents($path . '/.gitkeep', '');
                CLI::write("Sub Folder $nameSubFolder telah berhasil dibuat di dalam folder {$nameFolder}.");
            } else {
                CLI::error("Gagal membuat folder! Pastikan Anda memiliki izin yang cukup.");
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('checkFileExists')) {
    function checkFileExists($modulePath, $nameFile, $nameFolder, $nameSubFolder = null)
    {
        $path = $modulePath . '/' . $nameFolder . '/' . $nameFile . '.php';

        if ($nameSubFolder) {
            $path = $modulePath . '/' . $nameFolder . '/' . $nameSubFolder . '/' . $nameFile . '.php';
        }

        if (is_file($path)) {
            CLI::error("File $nameFolder $nameFile sudah pernah dibuat!");
            return false;
        }

        return true;
    }
}

if (!function_exists('registerFilter')) {
    function registerFilter($nameModule, $nameFile)
    {
        $autoloadFile = APPPATH . 'Config/Filters.php';
        $autoloadContent = file_get_contents($autoloadFile);

        $search = 'public array $aliases = [';
        $nameFileLowerCase = lcfirst($nameFile);
        $newAliasKey = "'$nameFileLowerCase'";
        $newAliasValue = "\\Modules\\{$nameModule}\\Filters\\{$nameFile}::class";

        if (strpos($autoloadContent, $newAliasKey) === false) {
            $newEntry = "        $newAliasKey   => $newAliasValue,";
            $autoloadContent = str_replace($search, $search . "\n" . $newEntry, $autoloadContent);
            file_put_contents($autoloadFile, $autoloadContent);

            CLI::write("File '$nameFile' berhasil diregister ke Filters.php");
            return true;
        } else {
            CLI::write("Alias '$nameFile' sudah ada di Filters.php");
            return false;
        }
    }
}

if (!function_exists('registerRoute')) {
    function registerRoute($nameModule, $nameFile)
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $routesContent = file_get_contents($routesFile);

        $pathRoute = "require_once ROOTPATH . 'modules/$nameModule/Routes/$nameFile.php';";

        if (strpos($routesContent, $pathRoute) !== false) {
            CLI::write("Register route $nameFile sudah pernah dilakukan!");
            return false;
        }

        $varRoutePosition = strpos($routesContent, '/** @var RouteCollection $routes */');

        if ($varRoutePosition !== false) {
            $insertPosition = $varRoutePosition + strlen('/** @var RouteCollection $routes */');
            $newContent = substr($routesContent, 0, $insertPosition) . "\n\n$pathRoute" . substr($routesContent, $insertPosition);
        } else {
            $newContent = $routesContent . "\n\n$pathRoute";
        }

        file_put_contents($routesFile, $newContent);

        return true;
    }
}

if (!function_exists('makeDirFileGenerate')) {
    function makeDirFileGenerate($filePath)
    {
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        return true;
    }
}

if (!function_exists('moveFileGenerate')) {
    function moveFileGenerate($filePath, $content, $nameFile)
    {
        if (file_put_contents($filePath . '.php', $content) !== false) {
            CLI::write("File '{$nameFile}.php' berhasil dibuat di '{$filePath}'.");
            return true;
        } else {
            CLI::error("Gagal membuat file '{$nameFile}.php'. Pastikan Anda memiliki izin yang cukup.");
            return false;
        }
    }
}

if (!function_exists('subFolderViewsGenerate')) {
    function subFolderViewsGenerate($pathViews)
    {
        $folders = ['components', 'layouts', 'pages'];
        $pathViews .= '/Views';

        foreach ($folders as $folder) {
            $folderPath = $pathViews . '/' . $folder;
            if (!is_dir($folderPath)) {
                mkdir($folderPath);
            }
        }
    }
}

if (!function_exists('contentController')) {
    function contentController($nameModule, $nameFile)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Controllers;\n\n";
        $content .= "use App\\Controllers\\BaseController;\n\n";
        $content .= "class " . $nameFile . " extends BaseController\n";
        $content .= "{\n";
        $content .= "    public function index()\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentModel')) {
    function contentModel($nameFile, $nameModel)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModel . "\\Models;\n\n";
        $content .= "use CodeIgniter\\Model;\n\n";
        $content .= "class " . ucfirst($nameFile) . " extends Model\n";
        $content .= "{\n";
        $content .= "    protected \$table            = '';\n";
        $content .= "    protected \$primaryKey       = 'id';\n";
        $content .= "    protected \$useAutoIncrement = true;\n";
        $content .= "    protected \$returnType       = 'array';\n";
        $content .= "    protected \$useSoftDeletes   = false;\n";
        $content .= "    protected \$protectFields    = true;\n";
        $content .= "    protected \$allowedFields    = [];\n\n";
        $content .= "    protected bool \$allowEmptyInserts = false;\n";
        $content .= "    protected bool \$updateOnlyChanged = true;\n\n";
        $content .= "    protected array \$casts = [];\n";
        $content .= "    protected array \$castHandlers = [];\n\n";
        $content .= "    // Dates\n";
        $content .= "    protected \$useTimestamps = false;\n";
        $content .= "    protected \$dateFormat    = 'datetime';\n";
        $content .= "    protected \$createdField  = 'created_at';\n";
        $content .= "    protected \$updatedField  = 'updated_at';\n";
        $content .= "    protected \$deletedField  = 'deleted_at';\n\n";
        $content .= "    // Validation\n";
        $content .= "    protected \$validationRules      = [];\n";
        $content .= "    protected \$validationMessages   = [];\n";
        $content .= "    protected \$skipValidation       = false;\n";
        $content .= "    protected \$cleanValidationRules = true;\n\n";
        $content .= "    // Callbacks\n";
        $content .= "    protected \$allowCallbacks = true;\n";
        $content .= "    protected \$beforeInsert   = [];\n";
        $content .= "    protected \$afterInsert    = [];\n";
        $content .= "    protected \$beforeUpdate   = [];\n";
        $content .= "    protected \$afterUpdate    = [];\n";
        $content .= "    protected \$beforeFind     = [];\n";
        $content .= "    protected \$afterFind      = [];\n";
        $content .= "    protected \$beforeDelete   = [];\n";
        $content .= "    protected \$afterDelete    = [];\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentService')) {
    function contentService($nameFile, $nameModule)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Services;\n\n";
        $content .= "class " . ucfirst($nameFile) . "\n";
        $content .= "{\n";
        $content .= "\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentRepository')) {
    function contentRepository($nameFile, $nameModule)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Repository;\n\n";
        $content .= "class " . ucfirst($nameFile) . "\n";
        $content .= "{\n";
        $content .= "\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentMigration')) {
    function contentMigration($nameModule)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Database\\Migrations;\n\n";
        $content .= "use CodeIgniter\\Database\\Migration;\n\n";
        $content .= "class " . ucfirst($nameModule) . " extends Migration\n";
        $content .= "{\n";
        $content .= "    public function up()\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n";

        $content .= "    public function down()\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentSeeder')) {
    function contentSeeder($nameModule, $nameFile)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Database\\Seeds;\n\n";
        $content .= "use CodeIgniter\\Database\\Seeder;\n\n";
        $content .= "class " . ucfirst($nameFile) . " extends Seeder\n";
        $content .= "{\n";
        $content .= "    public function run()\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentFilter')) {
    function contentFilter($nameModule, $nameFilter)
    {
        $content = "<?php\n\n";
        $content .= "namespace Modules\\" . $nameModule . "\\Filters;\n\n";
        $content .= "use CodeIgniter\\Filters\\FilterInterface;\n";
        $content .= "use CodeIgniter\\HTTP\\RequestInterface;\n";
        $content .= "use CodeIgniter\\HTTP\\ResponseInterface;\n\n";

        $content .= "class " . $nameFilter . " implements FilterInterface\n";
        $content .= "{\n";
        $content .= "    /**\n";
        $content .= "     * Do whatever processing this filter needs to do.\n";
        $content .= "     * By default it should not return anything during\n";
        $content .= "     * normal execution. However, when an abnormal state\n";
        $content .= "     * is found, it should return an instance of\n";
        $content .= "     * CodeIgniter\\HTTP\\Response. If it does, script\n";
        $content .= "     * execution will end and that Response will be\n";
        $content .= "     * sent back to the client, allowing for error pages,\n";
        $content .= "     * redirects, etc.\n";
        $content .= "     *\n";
        $content .= "     * @param RequestInterface \$request\n";
        $content .= "     * @param array|null       \$arguments\n";
        $content .= "     *\n";
        $content .= "     * @return RequestInterface|ResponseInterface|string|void\n";
        $content .= "     */\n";
        $content .= "    public function before(RequestInterface \$request, \$arguments = null)\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n\n";
        $content .= "    /**\n";
        $content .= "     * Allows After filters to inspect and modify the response\n";
        $content .= "     * object as needed. This method does not allow any way\n";
        $content .= "     * to stop execution of other after filters, short of\n";
        $content .= "     * throwing an Exception or Error.\n";
        $content .= "     *\n";
        $content .= "     * @param RequestInterface  \$request\n";
        $content .= "     * @param ResponseInterface \$response\n";
        $content .= "     * @param array|null        \$arguments\n";
        $content .= "     *\n";
        $content .= "     * @return ResponseInterface|void\n";
        $content .= "     */\n";
        $content .= "    public function after(RequestInterface \$request, ResponseInterface \$response, \$arguments = null)\n";
        $content .= "    {\n";
        $content .= "        //\n";
        $content .= "    }\n";
        $content .= "}\n";

        return $content;
    }
}

if (!function_exists('contentRoute')) {
    function contentRoute($nameModule)
    {
        $content = "<?php\n\n";
        $content .= "/**\n";
        $content .= " * List endpoint module $nameModule\n";
        $content .= " */\n";

        return $content;
    }
}
