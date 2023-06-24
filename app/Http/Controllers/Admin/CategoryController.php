<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\Admin\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()) {
            return response()->json([
                'result' => true,
            ]);
        }
        
        try {
            $data = $request->all();
            $this->categoryService->createCategory($data);
            $redirectRoute = 'categories.index';

            return $this->createSuccessRedirect($redirectRoute);
        } catch (\Exception $e) {
            $this->logError($e);

            return $this->errorBack(__('Ôi khum'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function getListCategory(Request $request)
    {
        $data = $this->categoryService->getListCategory($request->all());

        return (new SuccessResponse('Success', $data))->response();
    }
}
