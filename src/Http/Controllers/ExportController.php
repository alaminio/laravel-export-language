<?php


namespace Topup\LangExport\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Topup\LangExport\Exports\ExportExcelReport;

class ExportController extends Controller
{
    private $_langPath;
    private $_directories;
    private $_ds;

    public function __construct()
    {
        $this->_langPath = App::langPath();
        $this->_directories = glob($this->_langPath . '/*', GLOB_ONLYDIR);
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

                $languageFiles[$lang][] = [
                    'file' => $fileName,
                    'name' => $fileNameWithoutExtension,
                ];
            }
        }

        return view('topup-export-lang::index', compact('languageFiles'));
    }

    public function download($lang, $name)
    {
        Lang::setLocale($lang);
        $messages = Lang::get($name);

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
