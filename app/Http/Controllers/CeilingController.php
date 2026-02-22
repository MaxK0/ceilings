<?php

namespace App\Http\Controllers;

use App\Models\Ceiling;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Setting;
use Illuminate\Http\Request;

class CeilingController extends Controller
{
    public function index(Request $request)
    {
        $query = Ceiling::with(['category', 'manufacturer', 'images']);

        // Поиск по названию или описанию
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Фильтр по категории
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Фильтр по производителю
        if ($request->filled('manufacturer')) {
            $query->where('manufacturer_id', $request->manufacturer);
        }

        // Фильтр по толщине
        if ($request->filled('thickness')) {
            $query->where('thickness', $request->thickness);
        }

        // Фильтр по ширине (можно сделать выбор "до ... м")
        if ($request->filled('width')) {
            $query->where('width', '>=', $request->width);
        }

        // Сортировка по цене
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        } else {
            // Сортировка по умолчанию (например, по ID или названию)
            $query->orderBy('name');
        }

        $ceilings = $query->paginate(20)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $manufacturers = Manufacturer::orderBy('name')->get();
        $thicknesses = Ceiling::distinct()->orderBy('thickness')->pluck('thickness');
        $widths = Ceiling::distinct()->orderBy('width')->pluck('width');

        return view('ceilings.index', compact('ceilings', 'categories', 'manufacturers', 'thicknesses', 'widths'));
    }

    public function show($id)
    {
        $ceiling = Ceiling::with(['category', 'manufacturer', 'images'])->findOrFail($id);

        $cornerPrice = Setting::get('corner_price', 0);
        $lightPrice = Setting::get('light_price', 0);
        $chandelierPrice = Setting::get('chandelier_price', 0);

        return view('ceilings.show', compact('ceiling', 'cornerPrice', 'lightPrice', 'chandelierPrice'));
    }
}
