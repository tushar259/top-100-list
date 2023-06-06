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
		    ->select('id', 'table_name_starts_with', 'headline', 'nav_headline', 'priority')
		    ->where(function ($query) use ($routeName) {
		        $query->orWhere('table_name_starts_with', $routeName)
		            ->orWhere('headline', $routeName)
		            ->orWhere('nav_headline', $routeName);
		    })
		    ->distinct()
		    ->first();

		if($result != null){
			$data = DB::table($result->table_name_starts_with."_lists")
				->select("id", "name", "amount")
				->get();

			$result->all_childs = $data;

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
