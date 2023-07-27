<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\ProductService;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Product;
use App\Services\Admin\CategoryService;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $uploadFileController;

    function __construct(ProductService $productService, CategoryService $categoryService, UploadFileController $uploadFileController){
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->uploadFileController = $uploadFileController;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tempFolder = 'products/';
        $this->uploadFileController->deleteAllTempFile($tempFolder);

        $categories = $this->categoryService->getCategory();
        return view('products.create',  compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        
        if($request->ajax()) {
            return response()->json([
                'result' => true,
            ]);
        }
        try {
            $data = $request->all();
            $this->productService->createProduct($data);
            $redirectRoute = 'products.index';

            return $this->createSuccessRedirect($redirectRoute);
        } catch (\Exception $e) {
            $this->logError($e);

            return $this->errorBack(__('Ôi khum'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Xóa hết img trong tempFolder trước khi update
        $tempFolder = 'products/';
        $this->uploadFileController->deleteAllTempFile($tempFolder);

        $categories = $this->categoryService->getCategory();
        $product = $this->productService->getProductById($id);

        return view('products.edit',  compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $productId)
    {
        
        if($request->ajax()) {
            return response()->json([
                'result' => true,
            ]);
        }
        
        try {
            $data = $request->all();
            $this->productService->updateProduct($data, $productId);
            $redirectRoute = 'products.index';

            return $this->updateSuccessRedirect($redirectRoute);
        } catch (\Exception $e) {
            $this->logError($e);

            return $this->errorBack(__('common.messages.error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->productService->deleteProductById($id);
            $redirectRoute = 'products.index';

            return $this->deleteSuccessRedirect($redirectRoute);
        } catch (\Exception $e) {
            $this->logError($e);

            return $this->errorBack(__('common.messages.error'));
        }
    }

    public function getListProduct(Request $request)
    {
        $data = $this->productService->getListProduct($request->all());
        return (new SuccessResponse('Success', $data))->response();
    }
}
