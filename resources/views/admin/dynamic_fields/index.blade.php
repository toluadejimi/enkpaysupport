@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ $pageTitle }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __('Create Dynamic Fields For Ticket Create') }}</h2>
                        </div>
                        <form class="ajax reset" action="{{route('admin.dynamic-fields-store')}}" method="post"
                              data-handler="dynamicFieldResponse">
                            @csrf
                            <div class="row">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>{{__("Type")}}</th>
                                            <th>{{__("Level")}}</th>
                                            <th>{{__("Placeholder")}}</th>
                                            <th>{{__("Required")}}</th>
                                            <th>{{__("Field Width")}}</th>
                                            <th>{{__("Order")}}</th>
                                            <th class="text-center"><button class="btn btn-primary df-add-btn" type="button" id="addRowBtn"><i class="fa fa-plus"></i> </button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="type[]" disabled>
                                                    <option>{{__("Type")}}</option>
                                                    <option value="{{TEXT_FIELD_ID}}" selected>{{__("Text")}}</option>
                                                    <option value="{{TEXTAREA_FIELD_ID}}">{{__("Textarea")}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="level[]" value="{{__('Subject')}}" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="text" name="placeholder[]" value="{{__('Subject')}}" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <select class="form-control" name="required[]" disabled>
                                                    <option>{{__("Required")}}</option>
                                                    <option value="{{REQUIRED_NO}}">No</option>
                                                    <option value="{{REQUIRED_YES}}" selected>Yes</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="order[]" value="65" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="order[]" value="1" class="form-control" disabled>
                                            </td>
                                            <td class="text-center pt-3">
                                                <i class="fa fa-trash df-delete-btn-disable"></i>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <select class="form-control" name="type[]" disabled>
                                                    <option>{{__("Type")}}</option>
                                                    <option value="" selected>{{__("Option")}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="level[]" value="{{__('Category')}}" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="text" name="placeholder[]" value="{{__('Category')}}" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <select class="form-control" name="required[]" disabled>
                                                    <option>{{__("Required")}}</option>
                                                    <option value="{{REQUIRED_NO}}">No</option>
                                                    <option value="{{REQUIRED_YES}}" selected>Yes</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="order[]" value="35" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="order[]" value="2" class="form-control" disabled>
                                            </td>
                                            <td class="text-center pt-3">
                                                <i class="fa fa-trash df-delete-btn-disable"></i>
                                            </td>
                                        </tr>

                                        <span>
                                            @foreach($filedList as $item)
                                                <tr>
                                                <td>
                                                    <select class="form-control" name="type[]">
                                                        <option></option>
                                                        <option value="{{TEXT_FIELD_ID}}" {{$item->type == TEXT_FIELD_ID?'selected':''}}>Text</option>
                                                        <option value="{{TEXTAREA_FIELD_ID}}" {{$item->type == TEXTAREA_FIELD_ID?'selected':''}}>Textarea</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="level[]" value="{{$item->level}}" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="placeholder[]" value="{{$item->placeholder}}" class="form-control">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="required[]">
                                                        <option></option>
                                                        <option value="{{REQUIRED_NO}}" {{$item->required == REQUIRED_NO?'selected':''}}>No</option>
                                                        <option value="{{REQUIRED_YES}}" {{$item->required == REQUIRED_YES?'selected':''}}>Yes</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="width[]" value="{{$item->width}}" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" name="order[]" value="{{$item->order}}" class="form-control">
                                                </td>
                                                <td class="text-center pt-3">
                                                    <i class="fa fa-trash df-delete-btn removeBtn"></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </span>
                                    </tbody>
                                </table>

                                <div class="justify-content-end row text-end">
                                    <div class="col-md-12">
                                        <button class="btn btn-blue float-right df-submit-btn {{count($filedList)==0?'d-none':''}}" type="submit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
    <input type="hidden" id="TEXT_FIELD_ID" value="{{TEXT_FIELD_ID}}">
    <input type="hidden" id="TEXTAREA_FIELD_ID" value="{{TEXTAREA_FIELD_ID}}">
    <input type="hidden" id="REQUIRED_NO" value="{{REQUIRED_NO}}">
    <input type="hidden" id="REQUIRED_YES" value="{{REQUIRED_YES}}">
    <input type="hidden" id="fieldCount" value="{{count($filedList)}}">
@endsection
@push('script')
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/dynamic_field.js')}}"></script>

    <script>

    </script>
@endpush
