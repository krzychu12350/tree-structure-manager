<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json($this->tree());
    }

    public function tree()
    {
        $allCategories = Category::all();

        $rootCategories = $allCategories->whereNull('parent_id');

        self::formatTree($rootCategories, $allCategories);

        return $rootCategories;
    }

    private function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();

            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //Validate data
        $categoryData = $request->only('category_name', 'parent_id');

        $validator = Validator::make($categoryData, [
            'category_name' => 'required|string|max:255',
            'parent_id' => 'required|integer',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new category
        DB::select('call create_category(?, ?)', array($categoryData['category_name'], $categoryData['parent_id']));

        //Category created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Category was created successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        //Validate data
        $categoryData = $request->only('id_category', 'category_name', 'parent_id');

        $validator = Validator::make($categoryData, [
            'id_category' => 'required|integer',
            'category_name' => 'required|string|max:255',
            'parent_id' => 'required|integer',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update an existing category
        DB::select('call update_category(?, ?, ?)', array($categoryData['id_category'], $categoryData['category_name'], $categoryData['parent_id']));

        //Category created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Category was updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        //Validate data
        $categoryData = $request->only('id_category');

        $validator = Validator::make($categoryData, [
            'id_category' => 'required|integer',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        DB::select('call delete_category(?)', array($categoryData['id_category']));

        //Category deleted, return success response
        return response()->json([
            'success' => true,
            'message' => 'Category was deleted successfully',
        ], Response::HTTP_OK);
    }
}
