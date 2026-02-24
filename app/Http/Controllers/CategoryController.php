<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ceiling;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::with('ceilings')->findOrFail($id);

        $query = Ceiling::with(['category', 'manufacturer', 'images'])
            ->where('category_id', $id);

        if (request()->filled('manufacturer')) {
            $query->where('manufacturer_id', request()->manufacturer);
        }

        if (request()->filled('thickness')) {
            $query->where('thickness', request()->thickness);
        }

        if (request()->filled('width')) {
            $query->where('width', '>=', request()->width);
        }

        if (request()->filled('sort')) {
            switch (request()->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('name');
            }
        } else {
            $query->orderBy('name');
        }

        $ceilings = $query->paginate(20)->withQueryString();
        $manufacturers = Manufacturer::orderBy('name')->get();
        $thicknesses = Ceiling::distinct()->orderBy('thickness')->pluck('thickness');
        $widths = Ceiling::distinct()->orderBy('width')->pluck('width');

        return view('categories.show', compact('category', 'ceilings', 'manufacturers', 'thicknesses', 'widths'));
    }
}
