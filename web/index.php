<?php
error_reporting (E_ALL ^ E_NOTICE);
set_time_limit(0);

include 'template/_headermtmo.htm';

### do not forget to do 'composer require box/spout'

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

require_once 'autoload.php';
require_once 'tools.php';

$file = 'data1.xlsx';
$rows_max = 3;
$rows_count = 0;

# open the file
$reader = ReaderEntityFactory::createXLSXReader();
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
        foreach ($sheet->getRowIterator() as $rowKey => $row) {
            if ($rowKey > 3) {
                $tmp_cells = [];
                foreach ($row->getCells() as $cell) {

                    // Check if cell is date to prevent convert error.
                    $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

                        $doctorName = $tmp_cells[33];
                        $services = $tmp_cells[54];
                        $services = explode(',', $services);

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


foreach($data as $key_doctorName=>$value_services) {
    echo $key_doctorName . " ";
    foreach($value_services as $key_serviceName=>$value_count) {
        echo $key_serviceName . " - ". $value_count . " ";
    }
    echo "<br>";
}

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