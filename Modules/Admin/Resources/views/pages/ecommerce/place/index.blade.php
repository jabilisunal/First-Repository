@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('ecommerce.places.index')}}"> Places</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        @can('ecommerce:places-create')
        <div class="header-elements d-none">
            <a href="{{route('ecommerce.places.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-plus3"></i></b> Place əlavə et
            </a>
        </div>
        @endcan
    @endpush

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

    @can('ecommerce:places-index')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>Şəkil</td>
                                <td>Adı</td>
                                <td>Slug</td>
                                <td>Status</td>
                                <td>Tarix</td>
                                <th>Hərəkətlər</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($places as $key => $value)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td class="d-flex justify-content-center align-items-center">
                                    @if(isset($value->base_image))
                                        <img style="width: 60px; height: 60px; object-fit: contain;"
                                             src="/storage/public/media/{{$value?->base_image?->path}}" alt="{{$value->id}}"/>
                                    @else
                                        <img style="width: 60px; height: 60px; object-fit: contain;"
                                             src="{{asset('modules/admin/assets/img/no-photo.svg')}}" alt="{{$value->id}}"/>
                                    @endif
                                </td>
                                <td>{{$value->title}}</td>
                                <td>{{$value->slug}}</td>
                                <td>
                                    @if($value->status === 1)
                                        <span class="badge bg-success">Aktiv</span>
                                    @else
                                        <span class="badge bg-danger">Deaktiv</span>
                                    @endif
                                </td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <div class="list-icons">
                                        @can('ecommerce:places-show')
                                            <a target="_blank" href="{{route('ecommerce.places.show', [$value->id])}}" class="list-icons-item"><i class="icon-eye"></i></a>
                                        @endcan
                                        @can('ecommerce:places-edit')
                                            <a href="{{route('ecommerce.places.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('ecommerce:places-destroy')
                                            <button type="submit" class="list-icons-item m-0 p-0 border-0 btn-remove" data-id="{{$value->id}}"><i class="icon-trash"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @push('footer')
        <script type="text/javascript">
            $(document).ready(function () {

                let swalInit = swal.mixin({
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-light'
                });

                $(document).on('click', '.btn-remove', function () {

                    let id = $(this).data('id');

                    swalInit({
                        title: "Məlumat !",
                        text: "Silmək istədiyinizdən əminsiniz ?",
                        type: "warning",
                        showCancelButton: true,
                        showConfirmButton: true,
                        cancelButtonText: 'Ləğv et',
                        confirmButtonText: 'Sil',
                        confirmButtonClass: 'btn bg-teal-400',
                        cancelButtonClass: 'btn bg-danger-400'
                    }).then((result) => {

                        if(result.value) {

                            $.ajax({
                                type: 'DELETE',
                                url: '/admin/ecommerce/places/'+id,
                                data: {
                                    _token: $('meta[name="csrf_token"]').attr('content')
                                },
                                success: function (data) {
                                    if (data.status) {
                                        window.location='{{route('ecommerce.places.index')}}'
                                    } else {
                                        swalInit('Silinmədi', '', 'info');
                                    }
                                }
                            });
                        }
                        else if(result.dismiss === swal.DismissReason.cancel) {
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
