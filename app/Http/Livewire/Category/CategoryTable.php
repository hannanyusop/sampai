<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class CategoryTable extends Component
{
    public $categories = [];
    public $category = null;

    public $category_title = '',$subcategory_title = '';

    public $action_type = 'create';

    public function mount()
    {
        $this->fetchCategories();
    }

    public function render()
    {
        return view('livewire.category.category-table');
    }

    public function createCategory()
    {
        $this->validate([
            'category_title' => 'required|string|max:255|unique:categories,title,'
        ],[
            'category_title.required' => 'The category title field is required.',
            'category_title.unique' => 'The category title has already been taken.',
            'category_title.max' => 'The category title may not be greater than 255 characters.'
        ]);

        Category::create([
            'title' => $this->category_title
        ]);

        $this->category_title = '';
        $this->fetchCategories();
        session()->flash('message', 'Category created successfully.');
    }

    public function editCategory($id){
        $this->category       = Category::find($id);
        $this->category_title = $this->category->title;
        $this->action_type      = 'update';
    }

    public function deleteCategory($id)
    {
        Category::destroy($id);
        $this->fetchCategories();
    }

    public function updateCategory()
    {
        $this->validate([
            'category_title' => 'required|string|max:255|unique:categories,title,'.$this->category->id,
        ],[
            'category_title.required' => 'The category title field is required.',
            'category_title.unique' => 'The category title has already been taken.',
            'category_title.max' => 'The category title may not be greater than 255 characters.'
        ]);

        dd('sdf');

        $this->category->update([
            'title' => $this->category_title
        ]);

        dd($this->category_title);

        $this->category       = null;
        $this->category_title = '';
        $this->action_type    = 'update';

        $this->fetchCategories();
    }

    public function addSubcategory($id)
    {
        $this->category = Category::find($id);
        $this->action_type = 'add_subcategory';
    }

    public function cancel()
    {
        $this->category       = null;
        $this->category_title = '';
        $this->action_type    = 'create';
    }


    private function fetchCategories()
    {
        $this->categories = Category::get();
    }
}
