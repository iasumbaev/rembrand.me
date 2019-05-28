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
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "Число")
            ->setCellValue('B1', "Дата")
            ->setCellValue('C1', "Цена")
            ->setCellValue('D1', "Строка");

        if (isset($data['number'])) {
            $this->phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            if (is_array($data['number'])) {
                foreach ($data['number'] as $index => $number) {
                    $this->phpExcel->getActiveSheet()->setCellValue('A' . ($index + 2), $number);
                    $this->phpExcel->getActiveSheet()->getStyle('A' . ($index + 2))->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
            } else {
                $this->phpExcel->getActiveSheet()->setCellValue('A2', $data['number']);
                $this->phpExcel->getActiveSheet()->getStyle('A2')->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            }
        }

        if (isset($data['date'])) {
            $this->phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            if (is_array($data['date'])) {
                foreach ($data['date'] as $index => $date) {
                    $this->phpExcel->getActiveSheet()->setCellValue('B' . ($index + 2), $date);
                    $this->phpExcel->getActiveSheet()->getStyle('B' . ($index + 2))->getNumberFormat()
                        ->setFormatCode('dd.mm.yyyy');
                }
            } else {
                $this->phpExcel->getActiveSheet()->setCellValue('B2', $data['date']);
                $this->phpExcel->getActiveSheet()->getStyle('B2')->getNumberFormat()
                    ->setFormatCode('dd.mm.yyyy');
            }
        }

        if (isset($data['price'])) {
            $priceFormat = '_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)';
            $this->phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            if (is_array($data['price'])) {
                foreach ($data['price'] as $index => $price) {
                    $this->phpExcel->getActiveSheet()->setCellValue('C' . ($index + 2), $price);
                    $this->phpExcel->getActiveSheet()->getStyle('C' . ($index + 2))->getNumberFormat()
                        ->setFormatCode($priceFormat);
                }
            } else {
                $this->phpExcel->getActiveSheet()->setCellValue('C2', number_format($data['price'], 2, ",", " "));
            }
        }

        if (isset($data['string'])) {
            $this->phpExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            if (is_array($data['string'])) {
                foreach ($data['string'] as $index => $string) {
                    $this->phpExcel->getActiveSheet()->setCellValue('D' . ($index + 2), $string);
                    $this->phpExcel->getActiveSheet()->getStyle('D' . ($index + 2))->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                }

            } else {
                $this->phpExcel->getActiveSheet()->setCellValue('D2', $data['price']);
                $this->phpExcel->getActiveSheet()->getStyle('D2')->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
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
            file_put_contents("logs.log", "\n" . $currentDT.'ERROR: ' . $e, FILE_APPEND);
            return;
        }
        $dt = new DateTime();
        try {
            $this->phpExcel->save('file_' . $dt->format('d_m_Y_H_i_s') . '.xlsx');
        } catch (PHPExcel_Writer_Exception $e) {
            $currentDT = new DateTime();
            $currentDT = $currentDT->format('d-m-Y H:i:s');
            file_put_contents("logs.log", "\n" . $currentDT.' ERROR: ' . $e, FILE_APPEND);
            return;
        }
        $currentDT = new DateTime();
        $currentDT = $currentDT->format('d-m-Y H:i:s');
        file_put_contents("logs.log", "\n" . $currentDT . ' SUCCESS: saving file.', FILE_APPEND);

    }

}
