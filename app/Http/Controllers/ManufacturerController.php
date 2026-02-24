<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ceiling;
use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    public function show($id)
    {
        $manufacturer = Manufacturer::with('ceilings')->findOrFail($id);

        $query = Ceiling::with(['category', 'manufacturer', 'images'])
            ->where('manufacturer_id', $id);

        if (request()->filled('category')) {
            $query->where('category_id', request()->category);
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
        $categories = Category::orderBy('name')->get();
        $thicknesses = Ceiling::distinct()->orderBy('thickness')->pluck('thickness');
        $widths = Ceiling::distinct()->orderBy('width')->pluck('width');

        return view('manufacturers.show', compact('manufacturer', 'ceilings', 'categories', 'thicknesses', 'widths'));
    }
}
