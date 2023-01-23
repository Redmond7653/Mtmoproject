<?php

//include 'Classes/PHPExcel.php';
//include 'Classes/PHPExcel/Writer/Excel2007.php';

error_reporting (E_ALL ^ E_NOTICE);
set_time_limit(0);

include 'template/_headermtmo.htm';

### do not forget to do 'composer require box/spout'

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

require_once 'autoload.php';
require_once 'tools.php';

$file = 'testing.xlsx';
$rows_max = 3;
$rows_count = 0;

# open the file
$reader = ReaderEntityFactory::createXLSXReader();
$writer = WriterEntityFactory::createXLSXWriter();
$listServices = [];
$listDoctorNames = [];
$reader->open($file);
# read each cell of each row of each sheet


foreach ($reader->getSheetIterator() as $sheet) {
    $rows_count++;
//    echo "<br>\n============================ ROW {$rows_count} =======================<br>\n";

    if ($sheet->getIndex() === 0) {

        $table_rows = [];
        $table_header = [];
        $data = [];
        foreach ($sheet->getRowIterator() as $rowKey => $row) {
            if ($rowKey > 3) {
                $tmp_cells = [];
                foreach ($row->getCells() as $cell) {

                    // Check if cell is date to prevent convert error.
                    $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

                        $doctorName = $tmp_cells[33];
                        $services = $tmp_cells[54];
                        $comment = $tmp_cells[57];
                        $services = explode(',', $services);


                            if ($comment == 'ВІЛ - Відсутня процедура з видачі препарату' || $comment == 'ВІЛ - не останній заклад' || $comment == 'Медичні записи про виявлені клінічні випадки які надані одному пацієнту протягом одного (безперервного) проміжку часу перебування пацієнта у одного надавача медичних послуг' || $comment == 'Медичні записи, які визнано дублікатами на підставі співпадіння ключових атрибутів' || $comment == 'Помилковий запис (Entered in error)') {
                                break;
                            }
                            if (!empty($tmp_cells[57])) {
                                $found = false;
                                foreach ($services as $number_of_service) {
                                    $check = '9.';
                                    $pos = strpos($number_of_service, $check);
                                    if ($pos === 0) {
                                        $tableColumns[$number_of_service] = $number_of_service;
                                        $data[$doctorName][$number_of_service] = $data[$doctorName][$number_of_service] + 1;
                                        $found = true;
                                    }
                                }
                                break;
                            }


                }
                $table_rows[] = $tmp_cells;
            }
            if ($rowKey > 250) {
                break;
            }

            if ($rowKey == 3) {
                $tmp_cells = [];
                foreach ($row->getCells() as $cell) {

                    // Check if cell is date to prevent convert error.
                    $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

                }
                $table_header = $tmp_cells;
            }
        }

//        foreach ($sheet->getRowIterator() as $rowKey => $row) {
//            if ($rowKey === 24) {
//                $data = [];
//                foreach ($row->getCells() as $cellKey => $cell) {
//                    if ($cellKey <= 33) {
//                        $data[] = $cell->getValue();
//                    }
//                }
//                echo "<pre>";
//                var_export($data);
//                echo "</pre>";
//                break;
//            }
//
//        }
    }
    if ($rows_count > $rows_max) {
        break;
    }
}


//foreach($data as $key_doctorName=>$value_services) {
//    echo $key_doctorName . " ";
//    foreach($value_services as $key_serviceName=>$value_count) {
//        echo $key_serviceName . " - ". $value_count . " ";
//    }
//    echo "<br>";
//}






$writer = WriterEntityFactory::createXLSXWriter();
// $writer = WriterEntityFactory::createODSWriter();
// $writer = WriterEntityFactory::createCSVWriter();

$writer->openToFile("paket_9.xlsx"); // write data to a file or to a PHP stream
//$writer->openToBrowser($fileName); // stream data directly to the browser


//$cells = [
//    WriterEntityFactory::createCell('Лікар, що створив взаємодію'),
//];
//foreach ($tableColumns as $tableColumn) {
//    $cells[] = WriterEntityFactory::createCell($tableColumn);
//}
//$singleRow = WriterEntityFactory::createRow($cells);
//$writer->addRow($singleRow);


//Створити дві строкі, в першій строці сирі несортовані дані, в другій строці ті самі сортовані дані

$zebraBlackStyle = (new StyleBuilder())
    ->setBackgroundColor(Color::GREEN)
    ->setFontColor(Color::WHITE)
    ->setFontSize(12)
    ->setCellAlignment('center')
    ->build();

$zebraWhiteStyle = (new StyleBuilder())
    ->setBackgroundColor(Color::BLUE)
    ->setFontColor(Color::WHITE)
    ->setFontSize(12)
    ->setCellAlignment('center')
    ->build();


$sumStyle = (new StyleBuilder())
    ->setBackgroundColor(Color::BLUE)
    ->setFontColor(Color::WHITE)
    ->setFontSize(12)
    ->setFontBold()
    ->setCellAlignment('center')
    ->build();


$cells = [
    WriterEntityFactory::createCell('Лікар, що створив взаємодію', $zebraWhiteStyle),
];

//foreach ($tableColumns as $key=>$value) {
//    $tableColumns[$key] = (float) $tableColumns[$key];
//}

natsort($tableColumns);


foreach ($tableColumns as $tableColumn) {
    $cells[] = WriterEntityFactory::createCell($tableColumn, $zebraBlackStyle);
}
$cells[] = WriterEntityFactory::createCell('Всього', $zebraBlackStyle);
$cells[] = WriterEntityFactory::createCell('0.05', $zebraBlackStyle);
$singleRow = WriterEntityFactory::createRow($cells);
$writer->addRow($singleRow);


$doctor_services = [];
$sum = 0;
$koef = [
    '9.1' => 55.65,
    '9.2' => 108.15,
    '9.3' => 211.80,
    '9.4' => 324.75,
    '9.5' => 176.10,
    '9.6' => 590.25,
    '9.7' => 335.40,
    '9.8' => 506.85,
    '9.9' => 194.70,
    '9.10' => 123.45,
    '9.11' => 844.20,

];
//$test = '1';
//$test1 = '2';
$summary = [];
$total['sum'] = 0;
$total['sum.05'] = 0;
foreach($data as $key_doctorName=>$value_services) {
    $doctor_services = [WriterEntityFactory::createCell($key_doctorName)];
    foreach($tableColumns as $col) {
        if (isset($value_services[(string)$col])) {
            $doctor_services[] = WriterEntityFactory::createCell($value_services[(string)$col]);
//            $doctor_services[] = WriterEntityFactory::createCell((string)$col);
            $doctor_name[] = WriterEntityFactory::createCell($key_doctorName);
            $sum = $sum + $value_services[$col] * ($koef[$col] ?? 0);

            $small_part_of_sum = $sum * 0.05;

        } else {
            $doctor_services[] = WriterEntityFactory::createCell('');
        }
    }

    foreach ($value_services as $key=>$value) {
        if (isset($summary[$key])) {
            // Добавляти до існуючого елемету summary
            $summary[$key] = $summary[$key] + $value;
        } else {
            $summary[$key] = $value;
        }
    }
    $doctor_services[] = WriterEntityFactory::createCell($sum);
    $doctor_services[] = WriterEntityFactory::createCell($small_part_of_sum);
    $total['sum'] = $total['sum'] + $sum;
    $total['sum.05'] = $total['sum.05'] + $small_part_of_sum;
    $doctorRow = WriterEntityFactory::createRow($doctor_services);

    $writer->addRow($doctorRow);
    $sum = 0;
}
//$doctorRow = WriterEntityFactory::createRow($doctor_services);
//$writer->addRow($doctorRow);




/** add multiple rows at a time */
//$multipleRows = [
//    WriterEntityFactory::createRow($cells),
//    WriterEntityFactory::createRow($cells),
//];
//$writer->addRows($multipleRows);

$values1 = [''];
$rowFromValues = WriterEntityFactory::createRowFromArray($values1);
$writer->addRow($rowFromValues);


//$count = count($data)+1;
$values = ['Підсумок'];
foreach ($tableColumns as $element) {
    $values[] = $summary[$element];
}
$values[] = $total['sum'];
$values[] = $total['sum']*0.05;
//$column = 'A';
//foreach ($tableColumns as $services_count) {
//    $code = ord($column) + 1;
//    $column = chr($code);
//
//    $values[] = "=sum({$column}2:{$column}{$count})";
//}
$rowFromValues = WriterEntityFactory::createRowFromArray($values,$sumStyle);
$writer->addRow($rowFromValues);

$writer->close();


//$xls = new PHPExcel();
//$xls->setActiveSheetIndex(0);
//$sheet = $xls->getActiveSheet();
//
//$sheet->setCellValue("A1", 'Лікар, що створив взаємодію');
//
//for ($i = 'B'; $i <= count($tableColumns); $i++) {
//$sheet->setCellValue("{$i}1", sort($tableColumns));
//    }

include 'template/table.htm';

include 'template/_footermtmo.htm';

# close the file
$reader->close();


//$var = $value ? $value : "Другое значение";
//
//if ($value) {
//    $var = $value;
//} else {
//    $var = "Другое значение";
//}