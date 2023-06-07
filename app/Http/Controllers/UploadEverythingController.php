<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\All_Tables;

class UploadEverythingController extends Controller
{
    public function uploadHead(Request $request){
    	$title = $request->input("title");
    	$navTitle = $request->input("navTitle");
    	$priority = $request->input("priority");

    	if(!Schema::hasTable("all_tables")){
    		Schema::create("all_tables", function (Blueprint $table) {
                $table->increments('id');
                $table->string('table_name_starts_with')->unique();
                $table->string('headline')->unique();
                $table->string('nav_headline')->unique();
                $table->integer('priority')->nullable();
                $table->timestamps();
            });
    	}

    	$request->validate([
	        'title' => 'required|unique:all_tables,headline|min:3|max:255',
	        'navTitle' => 'required|unique:all_tables,nav_headline|min:3|max:255'
	    ]);

    	$tableNameStartsWith = time() . '_' . uniqid();

    	$newInsert = new All_Tables();
    	$newInsert->table_name_starts_with = $tableNameStartsWith;
    	$newInsert->headline = $title;
    	$newInsert->nav_headline = $navTitle;
    	if($priority != null && $priority > -1){
    		$newInsert->priority = $priority;
    	}
    	else{
    		$newInsert->priority = null;
    	}

    	if($newInsert->save()){

    		$currentEntryId = $newInsert->id;
    		$checkIfSuccess = $this->createCustomTable($request, $tableNameStartsWith);

    		if($checkIfSuccess == true){
    			return response()->json([
    				'idOfTable' => $currentEntryId,
		    		'message' => 'Data enterred.',
		    		'success' => true]);
    		}
    		else{
    			return response()->json([
		    		'message' => 'Custom table could not be created!',
		    		'success' => false]);
    		}
    		
    	}
    	else{
    		return response()->json([
	    		'message' => 'Data could not be enterred.',
	    		'success' => false]);
    	}
    }

    public function createCustomTable(Request $request, $tableNameStartsWith){
    	if(!Schema::hasTable($tableNameStartsWith."_lists")){
    		Schema::create($tableNameStartsWith."_lists", function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('amount')->nullable();
                $table->timestamps();
            });
    	}
    	return true;
    }

    public function getAllDataFromCustomAllTablesForUser(){
    	$request = new Request;
    	$data = DB::table("all_tables")
    		->select("id", "table_name_starts_with", "headline", "nav_headline", "priority")
    		->orderBy("nav_headline")
    		->get();
    	if($data->count() > 0){
    		foreach($data as $value){
    			if(Schema::hasTable($value->table_name_starts_with."_lists")){
	    			$childData = DB::table($value->table_name_starts_with."_lists")
	    				->select("id", "name", "amount")
	    				->get();
	    			if($childData->count() > 0){
	    				$value->lists_of_data = $childData;
	    			}
	    			else{
	    				$value->lists_of_data = null;
	    			}
    			}
    			else{
    				$checkIfSuccess = $this->createCustomTable($request, $value->table_name_starts_with);
    				$value->lists_of_data = null;
    			}
    		}

    	}
    	else{
    		return response()->json([
	    		'message' => 'No data found',
	    		'success' => false]);
    	}

    	return response()->json([
    			'allData' => $data,
	    		'message' => 'Data found',
	    		'success' => true]);


    }

    public function getAllDataFromCustomAllTables(){
    	$request = new Request;
    	$data = DB::table("all_tables")
    		->select("id", "table_name_starts_with", "headline", "nav_headline", "priority")
    		->get();
    	if($data->count() > 0){
    		foreach($data as $value){
    			if(Schema::hasTable($value->table_name_starts_with."_lists")){
	    			$childData = DB::table($value->table_name_starts_with."_lists")
	    				->select("id", "name", "amount")
	    				->get();
	    			if($childData->count() > 0){
	    				$value->lists_of_data = $childData;
	    			}
	    			else{
	    				$value->lists_of_data = null;
	    			}
    			}
    			else{
    				$checkIfSuccess = $this->createCustomTable($request, $value->table_name_starts_with);
    				$value->lists_of_data = null;
    			}
    		}

    	}
    	else{
    		return response()->json([
	    		'message' => 'No data found',
	    		'success' => false]);
    	}

    	return response()->json([
    			'allData' => $data,
	    		'message' => 'Data found',
	    		'success' => true]);


    }

    public function updateHeadlineNow(Request $request){
    	$headId = $request->input("headId");
    	$headline = $request->input("headline");
    	$navTitle = $request->input("navTitle");
    	$priority = $request->input("priority");

    	$checkIfHeadlineNotFound = $this->checkIfGivenHeadlineExist($request);
    	if($checkIfHeadlineNotFound == false){
    		return response()->json([
	    		'message' => 'Headline or Nav title already exist, Change them.',
	    		'success' => false]);
    	}
    	else{
    		$allTable = All_Tables::find($headId);

    		if($allTable == null){
    			return response()->json([
		    		'message' => 'Something went wrong, check server.',
		    		'success' => false]);
    		}
    		
    		$allTable->headline = $headline;
    		$allTable->nav_headline = $navTitle;
    		if($priority == null || $priority == ""){
    			$allTable->priority = null;
    		}
    		else{
    			$allTable->priority = $priority;
    		}
    		
    		if($allTable->save()){
    			return response()->json([
		    		'message' => 'Updated successfully.',
		    		'success' => true]);
    		}
    		else{
    			return response()->json([
		    		'message' => 'Something went wrong.',
		    		'success' => false]);
    		}
    	}
    }

    public function checkIfGivenHeadlineExist(Request $request){
    	$headId = $request->input("headId");
    	$headline = $request->input("headline");
    	$navTitle = $request->input("navTitle");
    	$priority = $request->input("priority");

    	$data = DB::table("all_tables")
    		->where("headline", $headline)
    		->where("nav_headline", $navTitle)
    		->where("id", "<>", $headId)
    		->get();

    	if($data->count() > 0){
    		return false;
    	}
    	else{
    		return true;
    	}
    }

    public function uploadAllNameAndAmount(Request $request){
    	$givenNameAndAmount = $request->json("givenNameAndAmount");
    	$selectedHeadlineId = $request->input("tableId");
    	$currentDate = date('Y-m-d');

    	// return $givenNameAndAmount;

    	$tableNameStartsWith = $this->getTableNameStartsWith($request);

    	if($tableNameStartsWith == false){
    		return response()->json([
	    		'message' => 'Something went wrong.',
	    		'success' => false]);
    	}
    	else{

	    	foreach ($givenNameAndAmount as $value) {
	    		if($value["name"] != ""){
	    			if($value["id"] == -100){
	    				DB::table($tableNameStartsWith."_lists")->insert([
						    'name' => $value["name"],
						    'amount' => $value["amount"]
						]);
	    			}
	    			else{
	    				DB::table($tableNameStartsWith."_lists")
						    ->where('id', $value["id"])
						    ->update([
						        'name' => $value["name"],
						    	'amount' => $value["amount"]
						    ]);
	    			}
	    		}
	    	}

	    	All_Tables::where("table_name_starts_with", $tableNameStartsWith)
	    		->update(['updated_at' => $currentDate]);
    	}
    	return response()->json([
    		'message' => 'Updated successfully.',
    		'success' => true]);

    }

    public function getTableNameStartsWith(Request $request){
    	$selectedHeadlineId = $request->input("tableId");

    	$data = All_Tables::select("table_name_starts_with")
    		->where("id", $selectedHeadlineId)
    		->first();

    	if ($data) {
	        return $data->table_name_starts_with;
	    } 
	    else{
	        return false;
	    }
    }

    public function deleteSpecificItem(Request $request){
    	$itemId = $request->input("itemId");
    	$tableId = $request->input("tableId");
    	$tableNameStartsWith = $this->getTableNameStartsWith($request);

    	if($tableNameStartsWith == false){
    		return response()->json([
	    		'message' => 'Something went wrong.',
	    		'success' => false]);
    	}
    	else{
    		$data = DB::table($tableNameStartsWith."_lists")
			    ->where('id', $itemId)
			    ->delete();

			if($data){
				return response()->json([
		    		'message' => 'Item deleted.',
		    		'success' => true]);
			}
			else{
				return response()->json([
		    		'message' => 'Something went wrong.',
		    		'success' => false]);
			}
    	}
    }
}
