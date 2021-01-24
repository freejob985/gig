@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
     </style>
@endsection
@section('site-title')
    {{__('Works')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Works Items')}}</h4>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_works as $key => $work)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_works as $key => $work)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default">
                                        <thead>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($work as $data)
                                            <tr>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>
                                                    @php $img_url = '';@endphp
                                                    @php
                                                        $work_section_img = get_attachment_image_by_id($data->image,null,true);
                                                        $img_url = '';
                                                    @endphp
                                                    @if (!empty($work_section_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$work_section_img['img_url']}}" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php  $img_url = $work_section_img['img_url']; @endphp
                                                    @endif
                                                </td>
                                                <td>{!! strip_tags(Str::words($data->description,20)) !!}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                                       role="button"
                                                       data-toggle="popover"
                                                       data-trigger="focus"
                                                       data-html="true"
                                                       title=""
                                                       data-content="
                                               <h6>Are you sure to delete this work item ?</h6>
                                               <form method='post' action='{{route('admin.work.delete',$data->id)}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <br>
                                                <input type='submit' class='btn btn-danger btn-sm' value='Yes,Delete'>
                                                </form>
                                                ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#work_item_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 work_edit_btn"
                                                       data-id="{{$data->id}}"
                                                       data-title="{{$data->title}}"
                                                       data-description="{{$data->description}}"
                                                       data-clients="{{$data->clients}}"
                                                       data-startdate="{{$data->start_date}}"
                                                       data-enddate="{{$data->end_date}}"
                                                       data-lang="{{$data->lang}}"
                                                       data-imageid="{{$data->image}}"
                                                       data-image="{{$img_url}}"
                                                       data-category="{{json_encode($data->categories_id)}}"
                                                    >
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                @php $b++; @endphp
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('New work')}}</h4>
                        <form action="{{route('admin.work')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="language">{{__('Language')}}</label>
                                <select name="lang" id="language" class="form-control">
                                    @foreach(get_all_language() as $language)
                                        <option value="{{$language->slug}}">{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  id="title"  name="title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="clients">{{__('Clients')}}</label>
                                <input type="text" class="form-control"  id="clients"  name="clients" placeholder="{{__('Clients')}}">
                            </div>
                            <div class="form-group">
                                <label for="start_date">{{__('Start Date')}}</label>
                                <input type="date" class="form-control"  id="start_date"  name="start_date" placeholder="{{__('Start Date')}}">
                            </div>
                            <div class="form-group">
                                <label for="end_date">{{__('End Date')}}</label>
                                <input type="date" class="form-control"  id="end_date"  name="end_date" placeholder="{{__('End Date')}}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <input type="hidden" name="description" id="description" >
                                <div class="summernote"></div>
                            </div>
                            <div class="form-group">
                                <label for="categories_id">{{__('Category')}}</label>
                                <select name="categories_id[]" multiple id="category" class="form-control nice-select wide">
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach($works_category as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">{{__('Image')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Work Image" data-modaltitle="Upload Work Image" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                                <small>{{__('Recommended image size 1920x1280')}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add work')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="work_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit work Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.work.update')}}" id="works_edit_modal_form" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="work_id" value="">
                        <div class="form-group">
                            <label for="edit_language">{{__('Language')}}</label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach(get_all_language() as $language)
                                    <option value="{{$language->slug}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title"  name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_clients">{{__('Clients')}}</label>
                            <input type="text" class="form-control"  id="edit_clients"  name="clients" placeholder="{{__('Clients')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_start_date">{{__('Start Date')}}</label>
                            <input type="date" class="form-control"  id="edit_start_date"  name="start_date" placeholder="{{__('Start Date')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_end_date">{{__('End Date')}}</label>
                            <input type="date" class="form-control"  id="edit_end_date"  name="end_date" placeholder="{{__('End Date')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{__('Description')}}</label>
                            <input type="hidden" name="description" id="edit_description">
                            <div class="summernote"></div>
                        </div>
                        <div class="form-group ">
                            <label for="edit_category">{{__('Category')}}</label>
                            <select name="categories_id[]" multiple id="edit_category" class="form-control wide">
                                <option value="">{{__('Select Category')}}</option>
                                @foreach($works_category as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" id="edit_image" name="image" value="">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Works Image" data-modaltitle="Upload Works Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('Recommended image size 1920x1280')}}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click','.work_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var description = el.data('description');
                var form = $('#works_edit_modal_form');
                var allCat = el.data('category');
                var imageid = el.data('imageid');
                var image = el.data('image');

                form.find('#work_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_clients').val(el.data('clients'));
                form.find('#edit_start_date').val(el.data('startdate'));
                form.find('#edit_end_date').val(el.data('enddate'));
                form.find('#edit_description').val(description);
                form.find('.summernote').summernote('code', description);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);

                if(imageid != ''){
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }

                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: el.data('lang')
                    },
                    success:function (data) {
                        $('#edit_category').niceSelect();
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            var selected = $.inArray(value.id.toString() ,allCat) != -1 ? 'selected' : '';
                            $('#edit_category').append('<option '+selected+' value="'+value.id+'">'+value.name+'</option>');
                            $('#edit_category').niceSelect('update');
                        });
                    }
                });

            });

            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }


            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#category').html('');
                        $.each(data,function (index,value) {
                            $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('.nice-select').niceSelect('update');
                        });
                    }
                });
            });

            $(document).on('change','#edit_language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            $('#edit_category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('#edit_category').niceSelect('update');
                        })
                    }
                });
            });
        });
    </script>

    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.table-wrap > table').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
