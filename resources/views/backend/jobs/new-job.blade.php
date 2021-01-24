@extends('backend.admin-master')
@section('site-title')
    {{__('New Job Post')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Job Post')}}</h4>
                        <form action="{{route('admin.jobs.new')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="language"><strong>{{__('Language')}}</strong></label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $lang)
                                                <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control"  id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="position">{{__('Job Position')}}</label>
                                        <input type="text" class="form-control"  id="position" name="position" value="{{old('position')}}" placeholder="{{__('Position')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">{{__('Company Name')}}</label>
                                        <input type="text" class="form-control"  id="company_name" value="{{old('company_name')}}"  name="company_name" placeholder="{{__('Company Name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">{{__('Category')}}</label>
                                        <select name="category_id" class="form-control" id="category">
                                            <option value="">{{__("Select Category")}}</option>
                                            @foreach($all_category as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vacancy">{{__('Vacancy')}}</label>
                                        <input type="text" class="form-control"  id="vacancy" value="{{old('vacancy')}}" name="vacancy" placeholder="{{__('Vacancy')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="job_context">{{__('Job Context')}}</label>
                                        <textarea name="job_context" id="job_context" class="form-control" cols="30" placeholder="{{__('Job Context')}}" rows="10">{{old('job_context')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_responsibility">{{__('Job Responsibility')}}</label>
                                        <textarea name="job_responsibility" id="job_responsibility" class="form-control" cols="30" placeholder="{{__('Job Responsibility')}}" rows="10">{{old('job_responsibility')}}</textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="education_requirement">{{__('Educational Requirements')}}</label>
                                        <textarea name="education_requirement" id="education_requirement" class="form-control" cols="30" placeholder="{{__('Educational Requirements')}}" rows="10">{{old('education_requirement')}}</textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_requirement">{{__('Experience Requirements')}}</label>
                                        <textarea name="experience_requirement" id="experience_requirement" class="form-control" cols="30" placeholder="{{__('Experience Requirements')}}" rows="10">{{old('experience_requirement')}}</textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="additional_requirement">{{__('Additional Requirements')}}</label>
                                        <textarea name="additional_requirement" id="additional_requirement" class="form-control" cols="30" placeholder="{{__('Additional Requirements')}}" rows="10">{{old('additional_requirement')}}</textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="employment_status">{{__('Employment Status')}}</label>
                                        <select name="employment_status" id="employment_status"  class="form-control">
                                            <option value="full_time">{{__('Full-Time')}}</option>
                                            <option value="part_time">{{__('Part-Time')}}</option>
                                            <option value="project_based">{{__('Project Based')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_location">{{__('Job Location')}}</label>
                                        <input type="text" class="form-control"  id="job_location" name="job_location" value="{{old('job_location')}}" placeholder="{{__('Job Location')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="other_benefits">{{__('Compensation & Other Benefits')}}</label>
                                        <textarea name="other_benefits" id="other_benefits" class="form-control" cols="30" placeholder="{{__('Compensation & Other Benefits')}}" rows="10">{{old('other_benefits')}}</textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{__('Email')}}</label>
                                        <input type="text" class="form-control"  id="email" value="{{old('email')}}" name="email" placeholder="{{__('Email')}}">
                                        <small class="info-text">{{__('enter an email address where everyone will apply to the post')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">{{__('Salary')}}</label>
                                        <input type="text" class="form-control"  id="salary" name="salary" value="{{old('salary')}}" placeholder="{{__('Salary')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="deadline">{{__('Deadline')}}</label>
                                        <input type="date" class="form-control"  id="deadline" name="deadline" placeholder="{{__('Deadline')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{__('Status')}}</label>
                                        <select name="status" id="status"  class="form-control">
                                            <option value="publish">{{__('Publish')}}</option>
                                            <option value="draft">{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Job')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $(document).on('change','#language',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.jobs.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">Select Category</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            });
        });
    </script>
@endsection
