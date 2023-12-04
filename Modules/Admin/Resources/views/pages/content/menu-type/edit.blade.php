@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.menu-type.index')}}"> Menyu tipinə düzəliş et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('content:menu-type-edit')
                <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-pencil"></i></b> Yadda saxla
                </button>
            @endcan
        </div>
    @endpush

    @can('content:menu-type-update')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{route('content.menu-type.update', [$type->id])}}" method="post" id="submit-form">
                            <fieldset class="mb-3">
                                @csrf
                                {{ method_field('PATCH') }}
                                <div class="form-group row">
                                    <label for="title" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('title')) text-danger @endif">
                                        Ad
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="title" name="title" type="text" value="{{$type->title}}" class="form-control @if($errors->has('title')) border-danger @endif">
                                            @if($errors->has('title'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('title'))
                                            <span class="form-text text-danger">{{$errors->first('title')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

