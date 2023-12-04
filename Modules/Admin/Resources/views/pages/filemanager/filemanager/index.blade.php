@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('localization.language.index')}}"> Fayl Menecer</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    @endpush

    @can('filemanager:filemanager-index')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card-body p-0">
                <form action="{{route('filemanager.filemanager.store')}}" class="dropzone" id="dropzone_multiple">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>

    @if (session('message'))
        <section id="errors" class="pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert m-0 alert-{{session('type')}}">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-adv">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Şəkil</th>
                            <th>Adı</th>
                            <th>Tarix</th>
                            <th>Hərəkətlər</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @push('footer')
        <script>

            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') === 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });

            $(".datatable-button-html5-adv").DataTable({
                ajax: '{{route('filemanager.filemanager.index', ['query' => ''])}}',
                columns: [
                    {data: "id"},
                    {data: "path"},
                    {data: "filename" },
                    {data: "created_at" },
                    {data: "action" }
                ],
                buttons: {
                    dom: {
                        button: {
                            className: 'btn btn-light'
                        }
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                }
            });
        </script>
    @endpush
@endsection
