@extends('layouts.master')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Create Category
    </h2>
    <form action="{{ route('categories.store') }}" id="create-form" method="post">
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>

                <input type="text" name="name" id="name" placeholder="Name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 input-val" />
                @error('name')
                    <span class="help-block has-error text-red-600">{{ $message }}</span>
                @enderror
                <p class="error_msg text-red-600" id="error-name"></p>
            </label>

            <div class="flex justify-end mt-4">
                <button type="button" id="btn-create" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
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
        $('#btn-create').on('click', function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            var data = $('#create-form').serialize(); 
            var name = $('#name').val(); 
            $.ajax({
                type: "POST",
                url: "{{ route('categories.store') }}",
                data: {
                    data: data,
                    name: name,
                },
                success: function(response) {
                    $(".error_msg").html('')
                    $(".input-val").removeClass("is-invalid");
                    $('#create-form').submit();
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