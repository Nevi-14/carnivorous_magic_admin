<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class PincodeController extends Controller {

    public function index_pincode($pincode_id) {
        session()->forget('pincode');
        session()->forget('pincode_no');
        session()->put('pincode', $pincode_id);

        $pincode_no = $this->post('locations', ['data' => ['get_pincodes' => '1', 'id' => $pincode_id]]);

        if (isset($pincode_no['error']) && !$pincode_no['error']) {
            $pincode_no = $pincode_no['data'][0]->pincode;

            session()->put('pincode_no', $pincode_no);

            $cache_pincode_no = Cache::get('pincode_no');

            return redirect()->back();
        } else {
            abort(404);
        }
    }

    public function index_pincode_clear() {

        session()->forget('pincode');
        session()->forget('pincode_no');
        return redirect()->back();
    }

    public function pincode_list(Request $request) {
        $limit = $request->limit;
        $offset = $request->offset;
        $arrSku = $this->post('locations', ['data' => ['get_pincodes' => '1', 'limit' => $limit, 'offset' => $offset]]);

        if (isset($arrSku['error']) && !$arrSku['error']) {
            $arrSku = $arrSku['data'];
            $arrNewSku = array();
            $incI = 0;
            foreach ($arrSku AS $arrData) {
                //$arrNewSku[$incI]['id'] = $arrData->id;
                $arrNewSku[] = $arrData->pincode;

                $incI++;
            }
            echo json_encode($arrNewSku);
        } else {
            abort(404);
        }
    }

    public function pincode_search(Request $request) {
        //$limit =  $request->limit;
        //$offset =  $request->offset;
        $search = $request->search;
        $arrSku = $this->post('locations', ['data' => ['get_pincodes' => '1', 'search' => $search, 'limit' => 19000]]);

        if (isset($arrSku['error']) && !$arrSku['error']) {
            $arrSku = $arrSku['data'];
            $arrNewSku = array();
            $incI = 0;
            foreach ($arrSku AS $arrData) {
                $arrNewSku[$incI]['id'] = $arrData->id;
                $arrNewSku[$incI]['pincode'] = $arrData->pincode;

                $incI++;
            }
            echo json_encode($arrNewSku);
        }
    }

    public function city(Request $request) {
        $arrSku = $this->post('locations', ['data' => ['get_cities' => '1', 'limit' => 20700]]);

        if (isset($arrSku['error']) && !$arrSku['error']) {
            $arrSku = $arrSku['data'];
            $arrNewSku = array();
            $incI = 0;
            foreach ($arrSku AS $arrData) {
                $arrNewSku[$incI]['id'] = $arrData->id;
                $arrNewSku[$incI]['name'] = $arrData->city_name;

                $incI++;
            }
            echo json_encode($arrNewSku);
        } else {
            abort(404);
        }
    }

    public function area(Request $request, $cityId = 0) {
        $arrSku2 = $this->post('locations', ['data' => ['get_areas' => '1', 'city_id' => $cityId, 'limit' => 20700]]);
        if (isset($arrSku2['error']) && !$arrSku2['error']) {
            $arrSku2 = $arrSku2['data'];
            $arrNewSku2 = array();
            $incI2 = 0;

            foreach ($arrSku2 AS $arrData2) {

                $arrNewSku2[$incI2]['id'] = $arrData2->id;
                $arrNewSku2[$incI2]['name'] = $arrData2->name;

                $incI2++;
            }
            $arrNewSku2[$incI2]['id'] = '';
            $arrNewSku2[$incI2]['name'] = 'Select Area';
            echo json_encode($arrNewSku2);
        } else {
            abort(404);
        }
    }

    public function pincode(Request $request, $areaId) {
        $arrSku2 = $this->post('locations', ['data' => ['get_pincodes' => '1', 'area_id' => $areaId, 'limit' => 20700]]);
        if (isset($arrSku2['error']) && !$arrSku2['error']) {
            $arrSku2 = $arrSku2['data'];
            $arrNewSku2 = array();
            $incI2 = 0;
            foreach ($arrSku2 AS $arrData2) {
                $arrNewSku2[$incI2]['id'] = $arrData2->id;
                $arrNewSku2[$incI2]['name'] = $arrData2->pincode;

                $incI2++;
            }
            echo json_encode($arrNewSku2);
        } else {
            abort(404);
        }
    }

}
