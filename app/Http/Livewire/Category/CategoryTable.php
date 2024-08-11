<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class CategoryTable extends Component
{
    public $categories = [];
    public $category = null;

    public $category_title = '',$subcategory_title = '';

    public $action_type = 'create';

    public function mount()
    {
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.category.category-table');
    }

    public function createCategory()
    {
        Category::create([
            'title' => $this->category_title
        ]);

        $this->category_title = '';
        $this->categories     = Category::all();
    }

    public function editCategory($id){
        $this->category       = Category::find($id);
        $this->category_title = $this->category->title;
        $this->action_type      = 'create';
    }

    public function updateCategory()
    {
        $this->category->update([
            'title' => $this->category_title
        ]);

        $this->category       = null;
        $this->category_title = '';
        $this->action_type    = 'update';

        $this->categories     = Category::all();
    }

    public function addSubcategory($id)
    {
        $this->category = Category::find($id);
        $this->action_type = 'add_subcategory';
    }

    public function createSubcategory()
    {
        $this->validate([
            'subcategory_title' => 'required|string|max:255|unique:subcategories,title,NULL,id,category_id,'.$this->category->id,
        ]);

        $this->category->subcategories()->create([
            'title' => $this->subcategory_title
        ]);

        $this->category_title = '';
        $this->subcategory_title = '';
        $this->categories     = Category::all();
        $this->category = null;

    }

    public function cancel()
    {
        $this->category       = null;
        $this->category_title = '';
        $this->action_type    = 'create';
    }
}
