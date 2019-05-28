<?php

require_once 'PHPExcel.php';

Class XlsxWork
{
    private $phpExcel;


    function __construct()
    {
        $this->phpExcel = new PHPExcel();
        $currentDT = new DateTime();
        $currentDT = $currentDT->format('d-m-Y H:i:s');
        file_put_contents("logs.log", "\n" . $currentDT . ' SUCCESS: creating object.', FILE_APPEND);
    }

    public function addData($data)
    {

        $letters = range('A', 'Z');
        $this->phpExcel->setActiveSheetIndex(0);

        $data['columns'] = array_values($data['columns']);
        foreach ($data['columns'] as $index => $item) {
            $this->phpExcel->getActiveSheet()
                ->setCellValue($letters[$index] . '1', $item['title']);
            $this->phpExcel->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
        }
        $priceFormat = '_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)';
        $data['rows'] = array_values($data['rows']);

        foreach ($data['rows'] as $index => $row) {
            $row = array_values($row);
            if(count($data['columns']) < count($row)) {
                throw new Exception('Некорректные данные');
            }
            foreach ($row as $jindex => $cellValue) {
                $cellCoordinates = $letters[$jindex] . ($index + 2);
                switch ($data['columns'][$jindex]['type']) {
                    case 'number':
                        $this->phpExcel->getActiveSheet()->setCellValue($cellCoordinates, $cellValue);
                        $this->phpExcel->getActiveSheet()->getStyle($cellCoordinates)->getNumberFormat()
                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        break;
                    case 'date':
                        $this->phpExcel->getActiveSheet()->setCellValue($cellCoordinates, $cellValue);
                        $this->phpExcel->getActiveSheet()->getStyle($cellCoordinates)->getNumberFormat()
                            ->setFormatCode('dd.mm.yyyy');
                        break;
                    case 'string':
                        $this->phpExcel->getActiveSheet()->setCellValue($cellCoordinates, $cellValue);
                        $this->phpExcel->getActiveSheet()->getStyle($cellCoordinates)->getNumberFormat()
                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                        break;
                    case 'price':
                        $this->phpExcel->getActiveSheet()->setCellValue($cellCoordinates, $cellValue);
                        $this->phpExcel->getActiveSheet()->getStyle($cellCoordinates)->getNumberFormat()
                            ->setFormatCode($priceFormat);
                        break;
                    default:
                        break;
                }
            }

        }
        $currentDT = new DateTime();
        $currentDT = $currentDT->format('d-m-Y H:i:s');
        file_put_contents("logs.log", "\n" . $currentDT . ' SUCCESS: adding data.', FILE_APPEND);
    }

    public function saveXlsx()
    {
        try {
            $this->phpExcel = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
        } catch (PHPExcel_Reader_Exception $e) {

            $currentDT = new DateTime();
            $currentDT = $currentDT->format(' d-m-Y H:i:s');
            file_put_contents("logs.log", "\n" . $currentDT . 'ERROR: ' . $e, FILE_APPEND);
            return;
        }
        $dt = new DateTime();
        try {
            $this->phpExcel->save('file_' . $dt->format('d_m_Y_H_i_s') . '.xlsx');
        } catch (PHPExcel_Writer_Exception $e) {
            $currentDT = new DateTime();
            $currentDT = $currentDT->format('d-m-Y H:i:s');
            file_put_contents("logs.log", "\n" . $currentDT . ' ERROR: ' . $e, FILE_APPEND);
            return;
        }
        $currentDT = new DateTime();
        $currentDT = $currentDT->format('d-m-Y H:i:s');
        file_put_contents("logs.log", "\n" . $currentDT . ' SUCCESS: saving file.', FILE_APPEND);

    }

}
