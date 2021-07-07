<?php

namespace Topup\LangExport\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExcelReport implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    private $_data;
    private $_headers;
    private $_keys;
    private $_format;
    private $_appendRows;

    public function __construct($exportable, $data, $format = [], $appendRows = [])
    {
        $this->_data = $data;
        $this->_headers = array_values($exportable);
        $this->_keys = array_keys($exportable);
        $this->_format = $format;
        $this->_appendRows = $appendRows;
    }

    public function headings(): array
    {
        return $this->_headers;
    }

    public function columnFormats(): array
    {
        return $this->_format;

    }

    public function array(): array
    {
        $data = [];

        foreach ($this->_data as $item) {
            $arr = [];
            foreach ($this->_keys as $key) {
                array_push($arr, $item[$key] ?? '');
            }

            array_push($data, $arr);
        }
        return count($this->_appendRows) > 1 ? array_merge($data, $this->_appendRows) : $data;
    }
}
