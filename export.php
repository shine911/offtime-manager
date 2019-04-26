<?php

session_start();
require dirname(__FILE__) . '/class/utils.php';
require dirname(__FILE__) . '/class/DBController.php';
require 'vendor/autoload.php';
if(!isset($_SESSION['taikhoan'])){
    header('Location: index.php');
}

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_GET['thang'])){
    $thang = $_GET['thang'];
    //Select and set to array
    $sql = "SELECT cb.TenCB, mh.tenMH, pc.TGBatDau, pc.TGKetThuc, pc.Thang, pc.Gio, pc.SoTiet from phancong AS pc, monhoc AS mh, canbo AS cb WHERE pc.MaCB = cb.MaCB AND pc.maMH = mh.maMH AND Thang = '$thang'";
    $result = DBController::customQuery($sql);
    $array = [];
    $index = 0;
    while($row = $result->fetch_assoc()){
        $array[$index] = $row;
        $index++;
    }
    //Read
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    //$spreadsheet = new Spreadsheet();
    $spreadsheet = $reader->load('assets/sample.xlsx');
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray($array, null, 'A2');

    $sheet->setTitle("Bang bao cao");

    /** DO NOT MODIFY. YOU DO OWN RISK */
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$thang.'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
    echo "<script>window.close();</script>";
    /** DO NOT MODIFY. YOU DO OWN RISK */

}