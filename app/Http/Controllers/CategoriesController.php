<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\Response;
use App\Category;
use App\SubCategory;

class CategoriesController extends Controller
{
    public function createCategory(Request $request)
    {
       $data = $request->all();
        try {
            $v = Validator::make($data, [
                "name"  => "required|max:50"
            ]);
            if ($v->fails()) {

                $status = Response::HTTP_BAD_REQUEST;
        
                $response = Array();
        
                $response['status'] = $status;
        
                if ($v->errors()->has('name')) {
                    $response['name'][] = [
                        'messages' => last($v->errors()->get('name')),
                        'field' => 'name',
                    ];
                }
            }
            $category = new Category();
            $category->name = $request['name'];
            $category->save();
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
                'message' => 'Category has been added successfully',
            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status);
    }
    public function createSubCategory(Request $request,$id)
    {
       $data = $request->all();
        try {
            $v = Validator::make($data, [
                "name"  => "required|max:50"
            ]);
            if ($v->fails()) {

                $status = Response::HTTP_BAD_REQUEST;
        
                $response = Array();
        
                $response['status'] = $status;
        
                if ($v->errors()->has('name')) {
                    $response['name'][] = [
                        'messages' => last($v->errors()->get('name')),
                        'field' => 'name',
                    ];
                }
            }
            $sub_category = new SubCategory();
            $sub_category->category_id = $data['id'];
            $sub_category->name = $request['name'];
            $sub_category->save();
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
                'message' => 'SubCategory has been added successfully',
            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status);
    }
    
}
