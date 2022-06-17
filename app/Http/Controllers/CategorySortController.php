<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategorySortController extends Controller
{
    /**
     * Sort the specified resource in database.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function sort(Request $request)
    {
        $categoriesSorted = Category::where('parent_id', 3)
            ->with('childs')
            ->orderBy('name', 'asc')
            ->get();

        $categoriesUnsorted = Category::where('parent_id', 3)
            ->with('childs')
            ->orderBy('id', 'asc')
            ->get();

        $subset1 = $categoriesUnsorted->map(function ($category) {
            return collect($category->toArray())
                ->only(['id'])
                ->all();
        });

        $subset2 = $categoriesSorted->map(function ($category) {
            return collect($category->toArray())
                ->only(['name'])
                ->all();
        });

        $keys = array();
        $values = array();

        foreach ($subset1 as $singleArray) {
            $keys[] = $singleArray['id'];
        }

        foreach ($subset2 as $singleArray) {
            $values[] = $singleArray['name'];
        }

        $array = array_combine($keys, $values);
        //dd($keys, $values, $array);

        return response()->json([
            'success' => true,
            'message' => 'Categories was sorted successfully',
        ], Response::HTTP_OK);
    }
}
