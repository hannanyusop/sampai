<div>

    @if($action_type == 'add_subcategory')
        <div class="my-3">
            <form>
                <div class="row g-3 align-center">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label" for="category">Category</label>
                            <input type="text" value="{{ $category->title }}" class="form-control" id="category" disabled>
                            <span class="form-note">Required | Max:50</span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label" for="subcategory">Subcategory</label>
                            <input type="text" wire:model="subcategory_title" class="form-control" id="subcategory" required>
                            <span class="form-note">Required | Max:50</span>
                            @error('subcategory_title')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <button wire:click="createSubcategory" class="btn btn-primary">Create New Subcategory</button>
                        <button wire:click="cancel" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="my-3">
            <form>
            <div class="row g-3 align-center">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" wire:model="category_title" class="form-control" id="title" required>
                        <span class="form-note">Required | Max:50</span>
                        @error('category_title')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    @if($action_type == 'create')
                        <button wire:click="createCategory" class="btn btn-primary">Create New Category</button>
                    @else
                        <button wire:click="updateCategory" class="btn btn-info">Update Category</button>
                    @endif
                </div>
            </div>
        </form>
        </div>
    @endif


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Active</th>
                <th>Subcategory</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->is_active ? "Active" : "Inactive" }}</td>
                    <td>
                        @foreach($category->subcategories as $subcategory)
                            {{ $subcategory->title }} {{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                    <td>
                        <a wire:click="editCategory({{ $category->id }})" class="btn btn-primary">Edit</a>
                        <a wire:click="addSubcategory({{ $category->id }})" class="btn btn-info">Add Subcategory</a>
                        <button wire:click="delete({{ $category->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
