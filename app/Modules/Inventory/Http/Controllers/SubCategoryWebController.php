<?php

namespace App\Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch\Branch;
use App\Models\Inventory\Item;
use App\Models\Inventory\ItemCategory;
use App\Models\Inventory\ItemSubCategory;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductPhase;
use App\Models\Inventory\ProductPhaseItem;
use App\Models\Inventory\Stock;
use App\Models\AccountChart\Account;

class SubCategoryWebController extends Controller
{
    public function index(){
        $category_name = ItemSubCategory::join('item_category', 'item_category.id','item_sub_category.item_category_id')
                            ->selectRaw('item_category.item_category_name as item_category_name')
                            ->get();

        $item_sub_categories = ItemSubCategory::all();
        return view('inventory::subcategory.index', compact('item_sub_categories', 'category_name'));

    }

    public function add()
    {
        $categories = ItemCategory::all();
        return view('inventory::subcategory.add', compact('categories'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'item_category_id' => 'required',
            'item_sub_category_name' => 'required',
        ]);

        try
        {
            $category_data = $request->all();
            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;

            $subcategory = new ItemSubCategory;

            $subcategory->item_category_id = $category_data['item_category_id'];
            $subcategory->item_sub_category_name = $category_data['item_sub_category_name'];
            $subcategory->item_sub_category_description = $category_data['item_sub_category_description'];
            $subcategory->created_by = $created_by;
            $subcategory->updated_by = $updated_by;


            if ($subcategory->save())
            {
                return redirect()
                    ->route('inventory_sub_category_add')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Sub Category added successfully!');
            }
            else
            {
                return redirect()
                    ->route('inventory_sub_category')
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'Sorry, something went wrong! Data cannot be saved.');
            }


        }
        catch (Exception $e)
        {
            return redirect()
                ->route('inventory_sub_category_add')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Refresh or reload the page and try again.');
        }
    }

    public function edit($id)
    {
        $categories = ItemCategory::all();
        $categoryById = ItemSubCategory::find($id);
        return view('inventory::subcategory.edit', compact('categoryById', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'item_category_id' => 'required',
            'item_sub_category_name' => 'required',
        ]);

        try
        {
            $category_data = $request->all();
            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;

            $subcategory = ItemSubCategory::find($id);
            
            $subcategory->item_category_id = $category_data['item_category_id'];
            $subcategory->item_sub_category_name = $category_data['item_sub_category_name'];
            $subcategory->item_sub_category_description = $category_data['item_sub_category_description'];
            $subcategory->created_by = $created_by;
            $subcategory->updated_by = $updated_by;

            if ($subcategory->update())
            {
                return redirect()
                    ->route('inventory_sub_category_edit', ['id' => $id])
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Sub Category updated successfully!');
            }
            else
            {
                return redirect()
                    ->route('inventory_sub_category_edit', ['id' => $id])
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'Sorry, something went wrong! Data cannot be updated.');
            }
        }
        catch (Exception $e)
        {
            return redirect()
                ->route('inventory_sub_category_edit', ['id' => $id])
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Refresh or reload the page and try again.');
        }
    }


    public function destroy($id)
    {

        $item_use = Item::where('item_sub_category_id', $id)->get();

        if (count($item_use) > 0)
        {
            return redirect()
                ->route('inventory_sub_category')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, sub category is used in item. You can not delete this sub category.');
        }

        $subcategory = ItemSubCategory::find($id);

        if ($subcategory->delete())
        {
            return redirect()
                ->route('inventory_sub_category')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Sub Category deleted successfully!');
        }
        else
        {
            return redirect()
                ->route('inventory_sub_category')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Data cannot be deleted.');
        }


    }
}
