<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\All_Tables;


class CustomUsersController extends Controller
{
    public function getCurrentComponentWith(Request $request){
    	$routeName = $request->input("routeName");

    	$result = DB::table('all_tables')
		    ->select('id', 'table_name_starts_with', 'headline', 'nav_headline', 'priority', 'updated_at')
		    ->where(function ($query) use ($routeName) {
		        $query->orWhere('table_name_starts_with', $routeName)
		            ->orWhere('headline', $routeName)
		            ->orWhere('nav_headline', $routeName);
		    })
		    ->distinct()
		    ->first();

		if($result != null){
			$data = DB::table($result->table_name_starts_with."_lists")
				->select("id", "name", DB::raw('REPLACE(TRIM(TRAILING "0" FROM ROUND(CAST(REPLACE(amount, ",", "") AS DECIMAL(65, 3)), 3)), ".", "") AS amount_bigdouble'))
				->orderByRaw('CAST(amount_bigdouble AS DECIMAL(65, 3)) DESC')
				->limit(100)
				->get();


			if($data->count() > 0){
				$result->all_childs = $data;
			}
			else{
				$result->all_childs = null;
			}

			return response()->json([
				'allData' => $result,
	    		'message' => 'Data found.',
	    		'success' => true]);
		}
		else{
			return response()->json([
	    		'message' => 'Data not found.',
	    		'success' => false]);
		}
    }
}
