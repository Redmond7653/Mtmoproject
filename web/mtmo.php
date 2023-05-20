<?php

//include 'Classes/PHPExcel.php';
//include 'Classes/PHPExcel/Writer/Excel2007.php';

error_reporting (E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
set_time_limit(0);

### do not forget to do 'composer require box/spout'

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

require_once 'autoload.php';


$file = trim($argv[1]);

var_export($file);
sleep(15);


$check_file = pathinfo($file);

$file_extension = $check_file['extension'];
$file_dirname = $check_file['dirname'];
$file_basename = $check_file['filename'];



    $rows_max = 3;
    $rows_count = 0;

# open the file
    $reader = ReaderEntityFactory::createXLSXReader();
    $writer = WriterEntityFactory::createXLSXWriter();
    $listServices = [];
    $listDoctorNames = [];


//echo $file;
//die();

//if (!file_exists($filesource)) {
//    die("File {$filesource} does not exist");
//}
//var_export($filesource);
//die('ok');


    echo "Ваш файл {$file} читається. \nЗачекайте 5-10 хвилин.";


    $reader->open($file);
# read each cell of each row of each sheet


    foreach ($reader->getSheetIterator() as $sheet) {
        $rows_count++;
//    echo "<br>\n============================ ROW {$rows_count} =======================<br>\n";

        if ($sheet->getIndex() === 0) {

            $table_rows = [];
            $table_header = [];
            $data = [];
            $r = 0;

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                if ($rowKey > 3) {
                    $tmp_cells = [];


                    foreach ($row->getCells() as $cell) {

                        // Check if cell is date to prevent convert error.
                        $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

                        $doctorName = $tmp_cells[33];
                        $services = $tmp_cells[54];
                        $comment = $tmp_cells[57];
                        $services = explode(",", $services);


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

//            if ($rowKey > 250) {
//                break;
//            }

                if ($rowKey == 3) {
                    $tmp_cells = [];
                    foreach ($row->getCells() as $cell) {

                        // Check if cell is date to prevent convert error.
                        $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

                    }
                    $table_header = $tmp_cells;
                }


                $r++;
                echo "Строка яка читається {$r} \n";


            }
        }
        if ($rows_count > $rows_max) {
            break;
        }

    }


    $writer = WriterEntityFactory::createXLSXWriter();
// $writer = WriterEntityFactory::createODSWriter();
// $writer = WriterEntityFactory::createCSVWriter();

    $output_file = "{$file_basename}._CONVERTED.xlsx";

    $writer->openToFile($output_file); // write data to a file or to a PHP stream
//$writer->openToBrowser($fileName); // stream data directly to the browser

    $path_to_file = dirname(__DIR__, 1);


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
//$project_array = '1';
//$test1 = '2';
    $summary = [];
    $total['sum'] = 0;
    $total['sum.05'] = 0;

    $count_rows = count($data);

    $y = 0;

    foreach ($data as $key_doctorName => $value_services) {
        $doctor_services = [WriterEntityFactory::createCell($key_doctorName)];

        foreach ($data as $test) {
            $y++;
            echo "Строка яка оброблюється {$y} \n";
        }

        foreach ($tableColumns as $col) {
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

        foreach ($value_services as $key => $value) {
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


    $values1 = [''];
    $rowFromValues = WriterEntityFactory::createRowFromArray($values1);
    $writer->addRow($rowFromValues);


//$count = count($data)+1;
    $values = ['Підсумок'];
    foreach ($tableColumns as $element) {
        $values[] = $summary[$element];
    }
    $values[] = $total['sum'];
    $values[] = $total['sum'] * 0.05;
    $rowFromValues = WriterEntityFactory::createRowFromArray($values, $sumStyle);
    $writer->addRow($rowFromValues);

    $writer->close();


//echo $count_rows;

    echo "Ваш файл {$output_file} готовий. Він знаходиться за шляхом {$path_to_file}.";

    exec("EXPLORER $path_to_file");
# close the file
    $reader->close();





