<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use Validator;
use Illuminate\Http\Response;
use \Milon\Barcode\DNS1D;

class ProductController extends Controller
{

    public function index()
    {
        $categories = Category::with('SubCategory',"Product")->get();;
        $sub_caregories = SubCategory::all();
        $products = Product::with('SubCategoryProduct',"CategoryProduct")->get();
      
        return response()->json(["products" => $products,"categories" => $categories, "sub_categories" => $sub_caregories ], 200);
    }

    public function uploadProduct(Request $request)
    {
        $data = $request->all();
        if(count($data['files']) > 9){
            return $response['messages'][] = [
                 'messages' => " maximum images and videos most be 9 attachments",
             ];
         }

        foreach($data['files'] as $file)
        {
           

            $asd = $file->getClientOriginalExtension();
            if($asd == 'jpg' || $asd == 'jpeg' || $asd == 'png' || $asd == 'bmp' || $asd == 'gif' || $asd == 'svg' ){
                $images[] = $file;
            }elseif($asd == 'mp4' || $asd == 'flv' || $asd == 'm3u8' || $asd == 'ts' || $asd == '3gp'|| $asd == 'mov' || $asd == 'avi') {;
                $videos[] = $file;
            }   
        }
        $data['images'] = $images ?? null;
        $data['videos'] = $videos ?? null;

    try {
        $v = Validator::make($data, [
            "case_count" => "required|",
            "name"  => "required|",
            "description"  => "required|",
            "brand"  => "required|",
            "size"  => "required|",
            "images"  => "required|array|max:9|",
            "images.*"  => "required|max:20480|",
            "videos"  => "required|array|max:9|",
            "videos.*"  => "required|max:51200|",
        ]);
        if ($v->fails()) {
            $status = Response::HTTP_BAD_REQUEST;

            $response = Array();

            $response['status'] = $status;

            if ($v->errors()->has('case_count')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('case_count')),
                    'field' => 'case_count',
                ];
            }
            if ($v->errors()->has('name')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('name')),
                    'field' => 'name',
                ];
            }
            if ($v->errors()->has('brand')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('brand')),
                    'field' => 'brand',
                ];
            }
            if ($v->errors()->has('size')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('size')),
                    'field' => 'size',
                ];
            }
            if ($v->errors()->has('images')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('images')),
                    'field' => 'images',
                ];
            }
            if ($v->errors()->has('videos')) {
                $response['messages'][] = [
                    'messages' => last($v->errors()->get('videos')),
                    'field' => 'videos',
                ];
            }

            return response()->json($response, $status);
        }

            $data['filesName'] = [];
    
            foreach($data['images'] as $file){
                $name = $file->getClientOriginalName();
                $image_size  = getimagesize($file);
                $file->move(public_path().'/files/img', $name);
                array_push($data['filesName'],$name);
            }
            foreach($data['videos'] as $file){
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/files/videos', $name);
                array_push($data['filesName'],$name);
            }

            // generate upc code
    

            // $randomCpc = rand(0,100000000000);
            $upc = DNS1D::getBarcodeHTML(rand(0,100000000000), "UPCA");
           
            // add Product
            $test = new Product();
            $test->category_id = $data['category_id'];
            $test->subcategory_id = $data['subcategory_id']?? null;
            $test->case_count = $data['case_count'];
            $test->name = $data['name'];
            $test->description = $data['description'];
            $test->brand = $data['brand'];
            $test->size = $data['size'];
            $test->file = $data['filesName'];
            $test->upc = $upc;
            $test->save();

        $status = Response::HTTP_OK;
        $response = [
            'status' => $status,
            'message' => 'Product has been added successfully',
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


  public function uploadCSV(Request $requset)
  {
     //get file
      $upload = $requset->file('csv-file');

      
      $filePath = $upload->getRealPath();

      //open and read
      $file = fopen($filePath, 'r');

     

      $header = fgetcsv($file);

      $escapedHeader = [];

      foreach($header as $key => $value){
          $low = strtolower($value);
          $escapedItem = preg_replace('/[^a-z]/','', $low);

          array_push($escapedHeader, $escapedItem);
      }

    
      //looping trough othe columms
      while($columms = fgetcsv($file))
      {
            if($columms[0]=="")
            {
                continue;
            }

            //trim data
            foreach($columms as $key => &$value)
            {
              $value = trim($value);
              //stex kgres validacioan
            }

            $data = array_combine($escapedHeader, $columms);

            //table update
            $case_count = $data['casecount'];
            $name = $data['name'];
            $description = $data["description"];
            $brand = $data['brand'];
            $size = $data['size'];
            $file_up = $data['file'];

            // generate upc code
            $upc = DNS1D::getBarcodeHTML(rand(0,100000000000), "UPCA");

            $test = Product::firstOrNew([
                'case_count'=> $case_count,
                "name" => $name,
                "description" => $description,
                "brand" => $brand,
                "size" => $size,
                "file" => $file_up,
                'upc' => $upc
                ]);
            $test->save();
            return response()->json(['message' => $test], 201);
      }
     
  }


  public function editProduct(Request $request,$id)
{
    $data = $request->all();
    foreach($data['files'] as $file)
    {
        $asd = $file->getClientOriginalExtension();
        if($asd == 'jpg' || $asd == 'jpeg' || $asd == 'png' || $asd == 'bmp' || $asd == 'gif' || $asd == 'svg' ){
            $images[] = $file;
        }elseif($asd == 'mp4' || $asd == 'flv' || $asd == 'm3u8' || $asd == 'ts' || $asd == '3gp'|| $asd == 'mov' || $asd == 'avi') {;
            $videos[] = $file;
        }   
    }
    $data['images'] = $images ?? null;
    $data['videos'] = $videos ?? null;

try {
    $v = Validator::make($data, [
        "case_count" => "required|",
        "name"  => "required|",
        "description"  => "required|",
        "brand"  => "required|",
        "size"  => "required|",
        "images"  => "required|array|max:9|",
        "images.*"  => "required|max:20480|",
        "videos"  => "required|array|max:9|",
        "videos.*"  => "required|max:51200|",
    ]);
    if ($v->fails()) {
        $status = Response::HTTP_BAD_REQUEST;

        $response = Array();

        $response['status'] = $status;

        if ($v->errors()->has('case_count')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('case_count')),
                'field' => 'case_count',
            ];
        }
        if ($v->errors()->has('name')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('name')),
                'field' => 'name',
            ];
        }
        if ($v->errors()->has('brand')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('brand')),
                'field' => 'brand',
            ];
        }
        if ($v->errors()->has('size')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('size')),
                'field' => 'size',
            ];
        }
        if ($v->errors()->has('images')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('images')),
                'field' => 'file',
            ];
        }
        if ($v->errors()->has('videos')) {
            $response['messages'][] = [
                'messages' => last($v->errors()->get('videos')),
                'field' => 'file',
            ];
        }

        return response()->json($response, $status);
    }

        $data['filesName'] = [];
   
        foreach($data['images'] as $file){
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/files/img', $name);
            array_push($data['filesName'],$name);
        }
        foreach($data['videos'] as $file){
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/files/videos', $name);
            array_push($data['filesName'],$name);
        }

        // generate upc code
       
        // add Product
        $test = Product::find($id);
        $test->category_id = $data['category_id']?? 1;
        $test->subcategory_id = $data['subcategory_id']?? 1;
        $test->case_count = $data['case_count'];
        $test->name = $data['name'];
        $test->description = $data['description'];
        $test->brand = $data['brand'];
        $test->size = $data['size'];
        $test->file = $data['filesName'];
        $test->save();
        
       $status = Response::HTTP_OK;
       $response = [
           'status' => $status,
           'message' => 'Product has been edit successfully',
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
