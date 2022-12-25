<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use PDF;

class InvoiceController extends Controller {

    function invoice_pdf1($orderId) {
        $pdf = \App::make('dompdf.wrapper');
        $data = $this->invoice_data($orderId);

        $pdf->loadHTML($this->invoice_data($orderId));

        return $pdf->stream("INV-" . $orderId . ".pdf", array("Attachment" => true));
    }

    function invoice_data($orderId) {
        $pdf = \App::make('dompdf.wrapper');
        $data = [api_param('get_order_invoice') => api_param('get-val'), api_param('user-id') => session()->get('user') ['user_id'], 'order_id' => $orderId];

        $list = $this->post('order-process', ['data' => $data]);

        $list = $list['data'];

        $output = '
                    <style>
.product_table, .product_table th, .product_table td {
  border: 1px solid black;
  border-collapse: collapse;
  padding:5px;
}
.left_side{
width:70%;
float:left;
}
.right_side{
width:30%;
float:right;
}
*{ font-family: DejaVu Sans !important;font-size:12px;}
.right{
  text-align:right
}
</style>
<html>
</head>
<head><title> ' . __('msg.invoice') . ' </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
 <style>
    
  </style>
            <p align="right">' . __('msg.invoice') . '</p>
            <h3 align="center">' . env('APP_NAME') . '</h3>
            <p align="center">' . __('msg.email') . ' : ' . (Cache::get('support_email')) . '<br/>
            ' . __('msg.customer_care') . ' : ' . (Cache::get('support_number')) . '<br/>
            
            <br/>
            <div class="left_side">
            <p align="left">' . __('msg.To') . '<br/>
            <b>' . $list[0]->user_name . '</b><br/>
            <b>' . $list[0]->mobile . '</b><br/>
            <b>' . $list[0]->email . '</b><br/>
            ' . $list[0]->address . '</p>
            </div>
            <div class="right">
            <p align="left">' . __('msg.retail_invoice') . '<br/>
            <b>' . __('msg.no') . ' : </b>' . $list[0]->items[0]->id . ' <br/>
            <b>' . __('msg.order_id') . ' : </b>' . $list[0]->id . ' <br/>
            <b>' . __('msg.date') . ' : </b>' . $list[0]->date_added . '<br/>
                </div>
            <br/><br/>
            <table class="product_table" width="100%">
            <tr>
            <td><b>' . __('msg.sr_no') . '</b></td>
            <td><b>' . __('msg.product_code') . '</b></td>
            <td><b>' . __('msg.name') . '</b></td>
            <td><b>' . __('msg.unit') . '</b></td>
            <td><b>' . __('msg.qty') . '</b></td>
            <td><b>' . __('msg.price') . '</b></td>
            </tr>';
        $i = 1;
        foreach ($list[0]->items as $itm) {
            $output .= '<tr>
             <td>' . $i . '</td>
             <td>' . $itm->product_variant_id . '</td>
             <td>' . $itm->product_name . '</td>
             <td>' . $itm->variant_name . '</td>
             <td>' . $itm->quantity . '</td>
             <td>' . get_price_varients($itm) . '</td>
             </tr>';
            $i++;
        }
        $output .= '</table><br/>';
        $output .= '<table class="right_side" width="40%">
            <tr>
            <td>' . __('msg.total_order_price') . '(' . Cache::get('currency') . ')</td>
            <td class="right">+ ' . $list[0]->total . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.delivery_charge') . '(' . Cache::get('currency') . ')</td>
            <td class="right">+ ' . $list[0]->delivery_charge . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.tax') . '(' . Cache::get('currency') . ')</td>
            <td class="right">+ ' . $list[0]->tax_amount . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.discount') . '(' . Cache::get('currency') . ')</td>
            <td class="right">- ' . $list[0]->discount . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.Promo') . ' (' . $list[0]->promo_code . ' ) ' . __('msg.Discount') . '(' . Cache::get('currency') . ')</td>
            <td class="right">- ' . $list[0]->promo_discount . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.wallet_used') . '(' . Cache::get('currency') . ')</td>
            <td class="right">- ' . $list[0]->wallet_balance . '</td>
            </tr>
                     <tr>
            <td>' . __('msg.final_total') . '(' . Cache::get('currency') . ')</td>
            <td class="right">= ' . $list[0]->final_total . '</td>
            </tr>
            </table>
            </html>';

        return $output;
    }

    function invoice_pdf($orderId) {
        if (isLoggedIn()) {
            $this->html('user.invoice', ['title' => __('msg.invoice'), 'id' => $orderId]);
        }else{
            abort(404);
        }
    }

}
