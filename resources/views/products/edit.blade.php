@extends('layouts.master')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Update
    </h2>
    <form action="{{ route('products.update', [$product->id]) }}" id="update-form" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>

                <input type="text" name="name" id="name" placeholder="Name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 input-val" value="{{ $product->name }}"/>
                @error('name')
                    <span class="help-block has-error text-red-600">{{ $message }}</span>
                @enderror
                <p class="error_msg text-red-600" id="error-name"></p>
            </label>
            <div class="grid grid-cols-3 gap-x-3">
                
                <label class="block mt-4 text-sm ">
                    <span class="text-gray-700 dark:text-gray-400">
                        Category
                    </span>
                    <select name="category_id" id="category_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Select category</option>

                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                    </select>
                    @error('category_id')
                        <span class="help-block has-error text-red-600">{{ $message }}</span>
                    @enderror
                    <p class="error_msg text-red-600" id="error-category_id"></p>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Price</span>
                    <input type="number" name="price" id="price" value="{{ $product->price }}" 
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                        focus:outline-none focus:shadow-outline-purple
                         dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Price" />
                    @error('price')
                        <span class="help-block has-error text-red-600">{{ $message }}</span>
                    @enderror
                    <p class="error_msg text-red-600" id="error-price"></p>
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Quantity</span>
                    <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}" class="block w-full mt-1 text-sm dark:bg-gray-700 input-val" placeholder="Quantity" />
                    @error('quantity')
                        <span class="help-block has-error text-red-600">{{ $message }}</span>
                    @enderror
                    <p class="error_msg text-red-600" id="error-quantity"></p>
                </label>
            </div>

            <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Description</span>
                <textarea name="description" id="description"  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Enter some long form content.">{{$product->description}}</textarea>
            </label>
            <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Product's image</span>
                <input id="thefiles" type="file" name="files[]" accept=".jpg, .png, image/jpeg, image/png" multiple />
                
                @error('files')
                    <span class="help-block has-error text-red-600">{{ $message }}</span>
                @enderror
                <p class="error_msg text-red-600" id="error-files"></p>  
            </label>
            <div class="flex justify-end mt-4">
                <button type="button" id="btn-update" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                    <span>Save</span>
                </button>
            </div>
        </div>
    </form>
</div>
</div>

@endsection
@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        var maxFiles = 5;
        var uploadedFiles = "{{ count($product->productImages) }}";
        $('#thefiles').FancyFileUpload({
            params: {
                action: 'fileuploader'
            },
            url: "{{ route('uploadFiles.store') }}",
            maxfilesize: 1000000,
            accept: ['jpg', 'jpeg', 'png'],
            postinit: function(settings) {
                @foreach ($product->productImages as $file)
                    $('.ff_fileupload_uploads').append(`
                        <tr class="old_file">
                            <input type="hidden" name=imageIds[] value = "{{ $file->id }}">
                            <td class="ff_fileupload_preview">
                                <button class="ff_fileupload_preview_image ff_fileupload_preview_image_has_preview ff_fileupload_preview_text_with_color ff_fileupload_preview_text_m" style="background-image: url('{{ asset('storage/' . $file->file_path) }}')" type="button" aria-label="Preview">
                                    <span class="ff_fileupload_preview_text"></span>
                                </button>
                            </td>
                            <td class="ff_fileupload_summary">
                                <div class="ff_fileupload_filename">{{ basename($file->file_path) }}</div>
                                <div class="ff_fileupload_fileinfo"></div>
                                <div class="ff_fileupload_buttoninfo ff_fileupload_hidden"></div>
                                <div class="ff_fileupload_errors ff_fileupload_hidden"></div>
                                <div class="ff_fileupload_progress_background ff_fileupload_hidden">
                                    <div class="ff_fileupload_progress_bar"></div>
                                </div>
                            </td>
                            <td class="ff_fileupload_actions">
                                <button class="ff_fileupload_remove_file remove_old_file" type = "button" aria-label="Remove from list">
                            </td>
                        </tr>`);
                @endforeach

                $('.ff_fileupload_remove_file').on('click', function() {
                    $(this).closest('.old_file').remove();
                    uploadedFiles--;
                });

                $('.ff_fileupload_preview_image_has_preview').on('click', function(e) {
                    e.preventDefault();

                    this.blur();
                    const imageUrl = $(this).css('background-image').replace('url("', '').replace('")', '');

                    $.fancybox.open({
                        src: imageUrl,
                        type: 'image',
                        opts: {
                        }
                    });
                })

            },
            added: function(e, data) {
                    if (uploadedFiles < maxFiles) {
                        $('#btn-update').attr('disabled', true);
                        this.find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
                    } else {
                        $("#error-img")
                        .addClass("has-error text-danger")
                        .text("{{ __('common.file_upload_error') }}")
                        .show();
                    }
                   
                    uploadedFiles++;
                },
            delete: function(e, data) {
                var filename = e.files[0].uploadName;     
                uploadedFiles--;
                $('.ff_fileupload_remove_file').on('click', function() {
                    $(this).closest('.old_file').remove();
                    uploadedFiles--;
                });
                if (uploadedFiles <= maxFiles) {
                    $("#error-img").hide();
                }
                $.ajax({
                    data: { filename: filename },
                    url: "{{ route('uploadFiles.destroy', ['uploadFile' => ':filename']) }}".replace(':filename', filename),
                    type: 'DELETE',
                    success: function(response) {
                        var index = uploadedFiles.indexOf(filename);
                        if (index !== -1) {
                            uploadedFiles.splice(index, 1);
                        }

                        if (uploadedFiles < maxFiles) {
                            $("#error-img").hide();
                            $('#btn-update').attr('disabled', false);
                        }

                        data.ff_info.widget.remove();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to delete file:', error);
                    }
                });
            },

            uploadcompleted: function(e, data) {
                if (!data.ff_info.removewidget) {
                    $('#btn-update').attr('disabled', false);
                }
            },
            langmap: {
                'File is too large.  Maximum file size is {0}.': "{{ __('common.invalid_size_fancyfile') }} {0}",
                'Upload completed': "{{ __('common.upload_success') }}",
                'Remove from list': "{{ __('common.delete_fancyfile') }}",
                'File invalid.': "{{ __('common.invalid_extension_fancyfile') }}",
                'Start uploading': "{{ __('common.upload_process') }}",
            }
        });

        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            var data = $('#update-form').serialize();          
            $.ajax({
                type: "PUT",
                url: "{{ route('products.update', $product->id) }}",
                data: {
                    data: data,
                    files: uploadedFiles,
                },
                success: function(response) {
                    $(".error_msg").html('')
                    $(".input-val").removeClass("is-invalid");
                    $('#update-form').submit();
                },
                error: function(xhr) {
                    $(".error_msg").html('');
                    $(".input-val").removeClass("is-invalid");
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $("#error-" + key).html(value);
                        $("#" + key).addClass("is-invalid");
                    });
                }
            });
        });
    });
</script>
@endsection