@extends('layouts.master')
@section('content')
<div class="container px-6 mx-auto grid">

    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Category
            </h2>
            <div>
                <a class="flex items-center justify-center px-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" href="{{ route('categories.create') }}">
                    <i class="fa-solid fa-plus"></i>
                    <span class="ml-2">Add</span>
                </a>
            </div>
        </div>
        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1 pr-4">
                <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500 search-form" >
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            @include('categories.elements.table_category')
        </div>
    </div>

</div>
@endsection
@section('script')

<script>
    $(document).ready(function() {
        var categoryTable = $('#category_table').DataTable({
            "fnDrawCallback": function(oSettings) {
                var pgr = $(oSettings.nTableWrapper).find('.dataTables_paginate')
                if (oSettings.fnRecordsDisplay() == 0) {
                    pgr.hide();
                    $(oSettings.nTableWrapper).find('.dataTables_info').hide();
                } else {
                    pgr.show();
                    $(oSettings.nTableWrapper).find('.dataTables_info').show();
                }
            },
            processing: true,
            serverSide: true,
            searching: true,
            "ordering": true,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('category.getListCategory') }}",
                type: "POST",
                data: function(d) {
                    d.keywords = $('#category_table_filter input').val();
                },
                dataSrc: function(response) {
                    response.recordsTotal = response.data.recordsTotal;
                    response.recordsFiltered = response.data.recordsTotal;
                    response.draw = response.data.draw;
                    return response.data.result;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == "{{ config('constant.authorize_code') }}") {
                        sessionAlert("{{ route('getLogin') }}", "{{ __('common.session_timeout') }}",
                            "{{ __('common.accept') }}");
                    }
                    if (jqXHR.status == "{{ config('constant.authorize_permission_code') }}") {
                        sessionAlert("{{ route('dashboard.index') }}",
                            "{{ __('common.permission_not_allow') }}",
                            "{{ __('common.accept') }}");
                    }
                }
            },
            autoWidth: false,
            columns: [{
                    data: "id",
                    orderable: true,
                    className: 'text-center media-middle',
                },
                {
                    data: "name",
                    orderable: true,
                    className: 'media-middle',
                },
                {
                    data: 'action',
                    className: 'text-center media-middle',
                    orderable: false,
                }
            ],
            language: {
                processing: "{{ __('common.datatable_processing') }}",
                lengthMenu: "{{ __('common.datatable_length_menu') }}",
                zeroRecords: "{{ __('common.datatable_zero_record') }}",
                info: "{{ __('common.datatable_info') }}",
                infoEmpty: "{{ __('common.datatable_info_empty') }}",
                infoFiltered: "{{ __('common.datatable_info_filtered') }}",
                searchPlaceholder: "Search...",
                search: "",
                paginate: {
                    "previous": "<i class='bx bxs-chevron-left' ></i>",
                    "next": "<i class='bx bxs-chevron-right' ></i>"
                }
            }
        });
        $("#category_table_filter input").addClass("w-1/2 rounded-lg border-0 shadow-lg pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:border-0 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input");
        $("#category_table_filter").prependTo(".search-form");

        $(document).on('submit', '.form-search', function(e) {
            e.preventDefault();
            form_search = $(this).serialize();
            categoryTable.draw();
        });

        $(document).on('click', '#deleteBtn', function() {
            let allids = [];
            let id = $(this).data('id');
            Swal.fire({
                title: "{{ __('common.are_you_sure') }}",
                text: "{{ __('common.delete_note') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "{{ config('constant.confirm_button_color') }}",
                cancelButtonColor: "{{ config('constant.cancel_button_color') }}",
                confirmButtonText: "{{ __('common.accept') }}",
                cancelButtonText: "{{ __('common.cancel_2') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form' + id).submit();
                }
            })
        });
    });
</script>
@endsection