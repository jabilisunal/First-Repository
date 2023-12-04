@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('ecommerce.tags.index')}}"> Vergi sinifinə düzəliş et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-hand"></i></b> Yadda saxla
            </button>
        </div>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('ecommerce.tags.update', [$tags->id])}}" method="post" enctype="multipart/form-data" id="submit-form">
                <div class="card border-top-0 border-right-1 border-bottom-1 border-left-1" style="border-radius: 0; border-color: #ddd;">
                    <div class="card-body">
                        <div class="tab-content">
                            <fieldset class="mb-3">
                                @csrf
                                {{ method_field('PATCH') }}

                                <div class="form-group row">
                                    <label for="slug" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('slug')) text-danger @endif">
                                        Slug
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="slug" name="slug" type="text"
                                                   value="{{$tags->slug}}"
                                                   class="form-control @if($errors->has('slug')) border-danger @endif">
                                            @if($errors->has('slug'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('slug'))
                                            <span class="form-text text-danger">{{$errors->first('slug')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('name')) text-danger @endif">
                                        Etiket
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="name" name="name" type="text"
                                                   value="{{$tags->name}}"
                                                   class="form-control @if($errors->has('name')) border-danger @endif">
                                            @if($errors->has('name'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('name'))
                                            <span class="form-text text-danger">{{$errors->first('name')}}</span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
