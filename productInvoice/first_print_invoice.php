<?php
//print_invoice.php

include('database_connection.php');
//include('pdf.php');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

if(isset($_GET["pdf"]) && isset($_GET["id"]))
{

    $logo = "https://www.sparksuite.com/images/logo.png";

    //query for product has been purchased
    $sql = 'SELECT tbl_order.order_no, tbl_order.order_no, tbl_order.order_receiver_name, tbl_order.order_datetime, tbl_order.order_total_after_tax, tbl_order_item.order_item_quantity,tbl_order_item.item_name,tbl_order_item.order_item_quantity,tbl_order_item.order_item_price
            FROM tbl_order_item
            INNER JOIN tbl_order ON tbl_order.order_id=tbl_order_item.order_id WHERE tbl_order.order_no = '.$_GET["id"].';';


    $result = $conn->query($sql);

    // query from the data which is going to return only single row

    //print_r($result); die;

    $output = '<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>A simple, clean, and responsive HTML invoice template</title>
    
            <style>
                .invoice-box {
                    max-width: 800px;
                    margin: auto;
                    padding: 30px;
                    border: 1px solid #eee;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                    font-size: 16px;
                    line-height: 24px;
                    font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                    color: #555;
                }
    
                .invoice-box table {
                    width: 100%;
                    line-height: inherit;
                    text-align: left;
                }
    
                .invoice-box table td {
                    padding: 5px;
                    vertical-align: top;
                }
    
                .invoice-box table tr td:nth-child(2) {
                    text-align: right;
                }
    
                .invoice-box table tr.top table td {
                    padding-bottom: 20px;
                }
    
                .invoice-box table tr.top table td.title {
                    font-size: 45px;
                    line-height: 45px;
                    color: #333;
                }
    
                .invoice-box table tr.information table td {
                    padding-bottom: 40px;
                }
    
                .invoice-box table tr.heading td {
                    background: #eee;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold;
                }
    
                .invoice-box table tr.details td {
                    padding-bottom: 20px;
                }
    
                .invoice-box table tr.item td {
                    border-bottom: 1px solid #eee;
                }
    
                .invoice-box table tr.item.last td {
                    border-bottom: none;
                }
    
                .invoice-box table tr.total td:nth-child(2) {
                    border-top: 2px solid #eee;
                    font-weight: bold;
                }
    
                @media only screen and (max-width: 600px) {
                    .invoice-box table tr.top table td {
                        width: 100%;
                        display: block;
                        text-align: center;
                    }
    
                    .invoice-box table tr.information table td {
                        width: 100%;
                        display: block;
                        text-align: center;
                    }
                }
    
                /** RTL **/
                .invoice-box.rtl {
                    direction: rtl;
                    font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                }
    
                .invoice-box.rtl table {
                    text-align: right;
                }
    
                .invoice-box.rtl table tr td:nth-child(2) {
                    text-align: left;
                }
            </style>
        </head>
    
        <body>
            <div class="invoice-box">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title">
                                        <img src= '.$logo.' style=\"width: 100%; max-width: 300px\"/>
                                    </td>

                                    <td>
                                        Invoice #: 123<br />
                                        Created: January 1, 2015<br />
                                        Due: February 1, 2015
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
    
                    <tr class="information">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td>
                                        Sparksuite, Inc.<br />
                                        12345 Sunny Road<br />
                                        Sunnyville, CA 12345
                                    </td>
    
                                    <td>
                                        Acme Corp.<br />
                                        John Doe<br />
                                        john@example.com
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
    
                    <tr class="heading">
                        <td>Payment Method</td>
    
                        <td>Check #</td>
                    </tr>
    
                    <tr class="details">
                        <td>Check</td>
    
                        <td>1000</td>
                    </tr>

                    <tr class="heading">
                        <td>Item</td>
    
                        <td>Price</td>
                    </tr>
                    ';

                    while($row = $result->fetch_assoc()) {

                $output .= '<tr class="item">
                        <td>'.$row['item_name'].'</td>
    
                        <td>$'.$row['order_item_price'].'</td>
                    </tr>';

                    }
                    
                    // while($row = $result->fetch_assoc()) {

                $output .= '<tr class="total">
                            <td></td>';
                            while($row = $result->fetch_assoc()) {
                            
                    $output .=    '<td>Total:'.$row['order_no'].'</td>';
                            }
                    $output .=    '</tr>';

                $output .= '</table>
            </div>
        </body>
    </html>
    ';
    $pdf = new Dompdf();
    //$file_name = 'Invoice-'.$row["order_no"].'.pdf';
    $file_name = 'Invoice-1'.'.pdf';
    $pdf->load_html($output);
    $pdf->setPaper('A4','landscape');
    $pdf->render();
    ob_end_clean();
    $pdf->stream($file_name, array("Attachment" => false));
    //$pdf->stream($file_name);
}
?>
