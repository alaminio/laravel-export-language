<?php


namespace Topup\LangExport\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Topup\LangExport\Exports\ExportExcelReport;

class ExportController extends Controller
{
    private $_languagePaths = [];
    private $_directories = [];
    private $_ds;

    public function __construct()
    {
        $this->_languagePaths[] = App::langPath();
        $this->_languagePaths[] = base_path('vendor/topup/cash-pickup/resources/lang');

        foreach ($this->_languagePaths as $path) {
            $dirs = glob($path . '/*', GLOB_ONLYDIR);
            if(is_array($dirs)) {
                $this->_directories = array_merge($this->_directories, $dirs);
            }

        }

        $this->_ds = DIRECTORY_SEPARATOR;
    }

    public function index()
    {
        $languageFiles = [];
        foreach ($this->_directories as $directory) {
            $parts = explode('/', $directory);
            $lang = end($parts);

            $files = glob($directory . '/*.php');

            foreach ($files as $file) {
                $parts = explode('/', $file);
                $fileName = end($parts);
                $fileNameWithoutExtension = str_replace('.php', '', $fileName);

                $package = 'main';
                if(strpos($file, 'cash-pickup')) {
                    $package = 'cash-pickup';
                }

                $languageFiles[$lang][] = [
                    'file' => $fileName,
                    'name' => $fileNameWithoutExtension,
                    'package' => $package,
                ];
            }
        }

        return view('topup-export-lang::index', compact('languageFiles'));
    }

    public function download($pkg, $lang, $name)
    {
        if($pkg === 'main') {
            $messages = require_once  App::langPath() . $this->_ds . $lang . $this->_ds . $name . '.php';
        } elseif ($pkg == 'cash-pickup') {
            $messages = require_once base_path('vendor/topup/cash-pickup/resources/lang') . $this->_ds . $lang . $this->_ds . $name . '.php';
        } else {
            return 'Something went wrong';
        }

        $data = [];
        $exportable = [
            'key' => 'Key',
            'message' => 'Message',
        ];

        foreach ($messages as $key => $message) {
            if(is_array($message) && isset($message['message'])) {
                $message = $message['message'];
            }
            $data[] = [
                'key' => $key,
                'message' => $message,
            ];
        }

        return (new ExportExcelReport($exportable, $data))->download($lang . '_' . $name . '.xls');
    }
}
