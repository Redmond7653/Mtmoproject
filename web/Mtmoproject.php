<?php

include 'template/_headermtmo.htm';

### do not forget to do 'composer require box/spout'

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

require_once 'autoload.php';
require_once 'tools.php';

$file = 'data.xlsx';
$rows_max = 3;
$rows_count = 0;

# open the file
$reader = ReaderEntityFactory::createXLSXReader();
$reader->open($file);
# read each cell of each row of each sheet


foreach ($reader->getSheetIterator() as $sheet) {
    $rows_count++;
//    echo "<br>\n============================ ROW {$rows_count} =======================<br>\n";

    if ($sheet->getIndex() === 0) {

        $table_rows = [];
        $table_header = [];
        foreach ($sheet->getRowIterator() as $rowKey => $row) {
            if ($rowKey > 5 && $rowKey < 200) {
                $tmp_cells = [];
                foreach ($row->getCells() as $cell) {

                    // Check if cell is date to prevent convert error.
                    $tmp_cells[] = $cell->isDate() ? $cell->getValue()->format('Y-m-d H:i') : $cell->getValue();

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