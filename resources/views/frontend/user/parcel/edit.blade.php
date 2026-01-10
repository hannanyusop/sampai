@extends('frontend.layouts.app')

@section('title', __('Edit Parcel'))

<style>
    .edit-parcel-container {
        padding-bottom: 100px;
    }

    /* Form Header */
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 24px 20px;
        color: white;
        text-align: center;
        margin: -1px -1px 0;
        position: relative;
    }

    @media (max-width: 767px) {
        .form-header {
            margin: 0;
            border-radius: 0;
        }
    }

    .form-header-back {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
    }

    .form-header-back:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        text-decoration: none;
    }

    .form-header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.75rem;
    }

    .form-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .form-header-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Form Sections */
    .form-section {
        padding: 0 16px;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 20px 4px 8px;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 20px;
    }

    /* Form Inputs */
    .app-form-group {
        margin-bottom: 20px;
    }

    .app-form-group:last-child {
        margin-bottom: 0;
    }

    .app-form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .app-form-label .required {
        color: #e53e3e;
    }

    .app-form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e5e5;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.2s;
        background: white;
    }

    .app-form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .app-form-input.is-invalid {
        border-color: #e53e3e;
    }

    .app-form-input[readonly] {
        background: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }

    .app-form-hint {
        font-size: 0.8rem;
        color: #888;
        margin-top: 6px;
    }

    .app-form-error {
        font-size: 0.8rem;
        color: #e53e3e;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Categories Grid */
    .categories-container {
        max-height: 280px;
        overflow-y: auto;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }

    .category-checkbox {
        display: none;
    }

    .category-item {
        display: flex;
    }

    .category-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 4px;
        background: #f5f6fa;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 500;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        min-height: 44px;
        line-height: 1.2;
        width: 100%;
    }

    .category-label:active {
        transform: scale(0.98);
    }

    .category-checkbox:checked + .category-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Collection Points */
    .collection-points {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .collection-radio {
        display: none;
    }

    .collection-label {
        display: flex;
        align-items: center;
        padding: 16px;
        background: #f5f6fa;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .collection-radio:checked + .collection-label {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 2px solid #667eea;
    }

    .collection-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: #667eea;
        font-size: 1.25rem;
    }

    .collection-info {
        flex: 1;
    }

    .collection-code {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
    }

    .collection-name {
        font-size: 0.8rem;
        color: #888;
    }

    .collection-check {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }

    .collection-radio:checked + .collection-label .collection-check {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }

    /* File Upload */
    .file-upload-wrap {
        position: relative;
    }

    .file-upload-area {
        border: 2px dashed #ddd;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-upload-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.02);
    }

    .file-upload-icon {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 8px;
    }

    .file-upload-text {
        font-size: 0.9rem;
        color: #666;
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .current-invoice {
        margin-top: 12px;
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .current-invoice-text {
        font-size: 0.85rem;
        color: #666;
    }

    .current-invoice-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
    }

    .current-invoice-link:hover {
        color: white;
        text-decoration: none;
        opacity: 0.9;
    }

    /* Submit Button */
    .submit-section {
        padding: 20px 16px;
        padding-bottom: calc(20px + env(safe-area-inset-bottom, 0px));
        background: white;
        position: sticky;
        bottom: 0;
        z-index: 20;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    }

    .submit-btn:active {
        transform: scale(0.98);
    }

    /* Textarea */
    .app-form-textarea {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e5e5;
        border-radius: 12px;
        font-size: 1rem;
        resize: vertical;
        min-height: 100px;
        transition: all 0.2s;
    }

    .app-form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Desktop */
    @media (min-width: 768px) {
        .edit-parcel-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-header {
            border-radius: 16px 16px 0 0;
            margin: 0;
        }

        .submit-section {
            position: relative;
            bottom: auto;
        }
    }

</style>

@section('content')
<div class="edit-parcel-container">
    <x-forms.post :action="route('frontend.user.parcel.update', $parcel->id)" class="form-validate" enctype="multipart/form-data">

        <!-- Form Header -->
        <div class="form-header">
            <a href="{{ route('frontend.user.parcel.show', encrypt($parcel->id)) }}" class="form-header-back">
                <i class="ni ni-arrow-left"></i>
            </a>
            <div class="form-header-icon">
                <i class="ni ni-edit"></i>
            </div>
            <div class="form-header-title">{{ __('Edit Parcel') }}</div>
            <div class="form-header-subtitle">{{ __('Update parcel details') }}</div>
        </div>

        <!-- Tracking Info -->
        <div class="form-section">
            <div class="section-title">{{ __('Tracking Information') }}</div>
            <div class="form-card">
                <div class="app-form-group">
                    <label class="app-form-label">
                        {{ __('Tracking Number') }} <span class="required">*</span>
                    </label>
                    <input type="text"
                           name="tracking_no"
                           class="app-form-input text-uppercase"
                           value="{{ old('tracking_no', $parcel->tracking_no) }}"
                           placeholder="{{ __('Enter tracking number') }}"
                           required>
                    @error('tracking_no')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Receiver Info -->
        <div class="form-section">
            <div class="section-title">{{ __('Receiver Information') }}</div>
            <div class="form-card">
                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Receiver Name') }} <span class="required">*</span></label>
                    <input type="text"
                           name="receiver_name"
                           class="app-form-input text-uppercase"
                           value="{{ old('receiver_name', $parcel->receiver_name) }}"
                           placeholder="{{ __('Enter receiver name') }}"
                           required>
                    @error('receiver_name')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Phone Number') }} <span class="required">*</span></label>
                    <input type="text"
                           name="phone_number"
                           class="app-form-input"
                           value="{{ old('phone_number', $parcel->phone_number) }}"
                           placeholder="{{ __('Enter phone number') }}"
                           required>
                    @error('phone_number')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Item Information -->
        <div class="form-section">
            <div class="section-title">{{ __('Item Information') }}</div>
            <div class="form-card">
                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Category') }} <span class="required">*</span></label>
                    <div class="categories-container">
                        <div class="categories-grid">
                            @foreach($categories as $category)
                                <div class="category-item">
                                    <input type="checkbox"
                                           name="category[]"
                                           value="{{ $category->id }}"
                                           id="cat_{{ $category->id }}"
                                           class="category-checkbox"
                                           {{ (is_array(old('category')) && in_array($category->id, old('category'))) || (!old('category') && in_array($category->id, array_keys($parcel->cat ?? []))) ? 'checked' : '' }}>
                                    <label for="cat_{{ $category->id }}" class="category-label">
                                        {{ $category->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="app-form-error category-error" id="categoryError" style="display: none;">
                        <i class="ni ni-alert-circle"></i> {{ __('Please select at least 1 category') }}
                    </div>
                    @error('category')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Item Description') }}</label>
                    <textarea name="description"
                              class="app-form-textarea"
                              placeholder="{{ __('Describe your items (e.g., Shirt 2pcs RM10)') }}">{{ old('description', $parcel->description) }}</textarea>
                    <div class="app-form-hint">{{ __('Max: 1000 characters. Simple description of items with quantity & price.') }}</div>
                    @error('description')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Quantity') }} <span class="required">*</span></label>
                    <input type="number"
                           name="quantity"
                           class="app-form-input"
                           value="{{ old('quantity', $parcel->quantity) }}"
                           placeholder="{{ __('Number of items') }}"
                           min="1"
                           required>
                    @error('quantity')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Price (RM)') }} <span class="required">*</span></label>
                    <input type="number"
                           name="price"
                           class="app-form-input"
                           value="{{ old('price', $parcel->price) }}"
                           placeholder="{{ __('Total price in RM') }}"
                           required>
                    @error('price')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Invoice -->
        <div class="form-section">
            <div class="section-title">{{ __('Invoice') }}</div>
            <div class="form-card">
                <div class="app-form-group">
                    <label class="app-form-label">{{ __('Invoice Image') }}</label>
                    <div class="file-upload-wrap">
                        <div class="file-upload-area">
                            <div class="file-upload-icon">
                                <i class="ni ni-upload-cloud"></i>
                            </div>
                            <div class="file-upload-text">{{ __('Tap to upload new invoice') }}</div>
                        </div>
                        <input type="file" name="invoice_url" class="file-upload-input" accept="image/*">
                    </div>
                    @if($parcel->invoice_url)
                        <div class="current-invoice">
                            <span class="current-invoice-text">{{ __('Current invoice') }}</span>
                            <a href="{{ route('frontend.user.parcel.download', encrypt($parcel->id)) }}" class="current-invoice-link" download>
                                <i class="ni ni-download"></i> {{ __('Download') }}
                            </a>
                        </div>
                    @endif
                    @error('invoice_url')
                        <div class="app-form-error">
                            <i class="ni ni-alert-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Collection Point -->
        <div class="form-section">
            <div class="section-title">{{ __('Collection Point') }} <span style="color: #e53e3e;">*</span></div>
            <div class="form-card">
                <div class="collection-points">
                    @foreach($drop_points as $drop_point)
                        <div>
                            <input type="radio"
                                   name="office_id"
                                   value="{{ $drop_point->id }}"
                                   id="office_{{ $drop_point->id }}"
                                   class="collection-radio"
                                   {{ old('office_id', $parcel->office_id) == $drop_point->id ? 'checked' : '' }}>
                            <label for="office_{{ $drop_point->id }}" class="collection-label">
                                <div class="collection-icon">
                                    <i class="ni ni-map-pin"></i>
                                </div>
                                <div class="collection-info">
                                    <div class="collection-code">{{ $drop_point->code }}</div>
                                    <div class="collection-name">{{ $drop_point->name }}</div>
                                </div>
                                <div class="collection-check">
                                    <i class="ni ni-check"></i>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('office_id')
                    <div class="app-form-error" style="margin-top: 12px;">
                        <i class="ni ni-alert-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="submit-section">
            <button type="submit" class="submit-btn">
                <i class="ni ni-check"></i> {{ __('Update Parcel') }}
            </button>
        </div>

    </x-forms.post>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Show form errors on page load
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: '{{ __("Error") }}',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#667eea'
        });
    @endif

    // Show success message
    @if(session('flash_success') || session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ __("Success") }}',
            text: '{{ session("flash_success") ?? session("success") }}',
            confirmButtonColor: '#667eea'
        });
    @endif

    // File upload preview
    document.querySelector('.file-upload-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            document.querySelector('.file-upload-text').textContent = fileName;
        }
    });

    // Form validation - require at least 1 category
    const categoryError = document.getElementById('categoryError');

    document.querySelector('.form-validate').addEventListener('submit', function(e) {
        const checkedCategories = document.querySelectorAll('.category-checkbox:checked');
        if (checkedCategories.length === 0) {
            e.preventDefault();
            categoryError.style.display = 'flex';
            Swal.fire({
                icon: 'error',
                title: '{{ __("Error") }}',
                text: '{{ __("Please select at least 1 category") }}',
                confirmButtonColor: '#667eea'
            });
            document.querySelector('.categories-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Hide error when category is selected
    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCategories = document.querySelectorAll('.category-checkbox:checked');
            if (checkedCategories.length > 0) {
                categoryError.style.display = 'none';
            }
        });
    });
</script>
@endsection
