<div>

    <div class="my-3">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('admin.category.store') }}">
            @csrf
            <div class="row g-3 align-center">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                        @error('title')
                        <div class="form-error text-danger fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary mt-4">Create New Category</button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <form action="{{ route('admin.category.updateCat', $category) }}">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                <tr>
                    <td><input class="form-control" type="text" name="title" value="{{ $category->title }}"></td>
                    <td>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button wire:click="deleteCategory({{ $category->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                </form>
            @endforeach
        </tbody>
    </table>
</div>
