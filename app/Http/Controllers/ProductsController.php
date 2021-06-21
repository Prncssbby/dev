<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
	public function index()
	{
		return view('products');
	}

	public function indexPerPage($page)
	{
		return view('products-per-page');
	}

	public function create()
	{
		return view('create-product');
	}

	public function edit($productId)
	{
		$data = ['productId' => $productId];

		$product = DB::select("SELECT id, name, category, description, date_time FROM products WHERE id = :productId", $data)[0];

		$productData = [
			'id' => $product->id,
			'name' => $product->name,
			'category' => $product->category,
			'description' => $product->description
		];

		return view('update-product', $productData);
	}

	public function show()
	{
		$products = DB::select('SELECT id, name, category, description, date_time FROM products');

		return response()->json($products);
	}

	public function showPerPage(Request $req)
	{
		$data = [
			'startRow' => $req->start,
			'limitRow' => $req->limit
		];

		$products = DB::select('SELECT id, name, category, description, date_time FROM products ORDER BY id DESC LIMIT :startRow, :limitRow', $data);

		return response()->json($products);
	}

	public function get($productId)
	{
		$data = [
			'productId' => $productId
		];

		$product = DB::select('SELECT name, category, description FROM products WHERE id = :productId', $data);

		return response()->json($product);
	}

    public function add(Request $req)
    {
    	$resp = [];
        $fileNo = (int)$req->fileNo;

    	$data = array(
	    	'name' => $req->name,
	    	'category' => $req->category,
	    	'description' => $req->description,
	    	'date_time' => $req->dateTime
    	);

    	$id = DB::table('products')->insertGetId($data);

        for($x = 0;$x < $req->fileNo; $x++)
        {
            $photos = array(
                'path' => $req->file('img'.$x)->store('img'),
                'product' => $id
            );

            DB::table('photos')->insert($photos);
        }


    	if($id) $resp = ['success' => 1];
    	else $resp = ['success' => 0];

    	return response()->json($resp);
    }

    public function update(Request $req)
    {
        $resp = [];
        $productId = $req->id;
        $fileNo = (int)$req->fileNo;

    	$data = [
    		'name' => $req->name,
    		'category' => $req->category,
    		'description' => $req->description,
    		'prodDateTime' => $req->updateProductDateTime,
    		'id' => $productId
    	];

    	$query = DB::update("UPDATE products SET name = :name, category = :category, description = :description, date_time = :prodDateTime WHERE id = :id", $data);


        if($fileNo > 0)
        {

            $photos = DB::select("SELECT id, path FROM photos WHERE product = :productId", ['productId' => $productId]);

            foreach($photos as $photo)
            {
                Storage::delete($photo->path);
                DB::delete("DELETE FROM photos WHERE id = :id", ['id' => $photo->id]);
            }

            for($x = 0; $x < $fileNo; $x++)
            {
                $photosArr = array(
                    'path' => $req->file('img'.$x)->store('img'),
                    'product' => $req->id
                );

                DB::table('photos')->insert($photosArr);
            }
        }

    	if($query) $resp = ['success' => 1];
    	else $resp = ['error' => 0];

    	return response()->json($resp);
    }

    public function delete(Request $req)
    {
    	$data = [
    		'id' => $req->id
    	];

    	$resp = [];

    	$query = DB::delete("DELETE FROM products WHERE id = :id", $data);

    	if($query) $resp = ['success' => 1];
    	else $resp = ['success' => 0];

    	return response()->json($resp);
    }

    public function search(Request $req)
    {
    	$data = [
    		'keywords1' => $req->keywords.'%',
    		'keywords2' => $req->keywords.'%'
    	];

		$products = DB::select('SELECT id, name, category, description, date_time FROM products WHERE  (name LIKE :keywords1 OR description LIKE :keywords2)', $data);

		return response()->json($products);
    }

    public function searchCategory(Request $req)
    {
    	$data = [
    		'category' => $req->category.'%'
    	];

		$products = DB::select('SELECT id, name, category, description, date_time FROM products WHERE  category LIKE :category', $data);

		return response()->json($products);
    }

    public function getProductPhotos(Request $req)
    {
        $photos = DB::select("SELECT id, path FROM photos WHERE product = :productId", ['productId' => $req->productId]);
        return response()->json($photos);
    }

    public function csrfToken()
    {
    	echo csrf_token();
    }
}
