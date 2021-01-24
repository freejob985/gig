@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"/>
    <link rel="stylesheet" href="{{asset('assets/backend/css/jquery.nested.sortable.css')}}"/>
@endsection
@section('site-title')
    {{__('Edit Menu')}}
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Edit Menu')}}</h4>
                        <form action="{{route('admin.menu.update',$page_post->id)}}" id="menu_update_form" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <textarea  id="menu_content" name="menu_content" style="display: none;" class="form-control" >{{$page_post->content}}</textarea>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Language')}}</label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $lang)
                                                <option @if($lang->slug == $page_post->lang) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               value="{{$page_post->title}}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="menu-left-side-content">
                                        <h3 class="title">{{__('Add menu items')}}</h3>
                                        <div class="accordion accordion-wrapper" id="add_menu_item_accordion">
                                            <div class="card">
                                                <div class="card-header" id="page-list-items">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#page-list-items-content"
                                                                aria-expanded="true"
                                                                aria-controls="page-list-items-content">
                                                            {{__('Pages')}}
                                                        </button>
                                                    </h2>
                                                </div>
                                                @php
                                                    $default_lang = get_default_language();
                                                    $static_page_list = ['About','Service','Faq','Team','Works','Price Plan','Career With Us','Events','Knowledgebase'];
                                                @endphp
                                                <div id="page-list-items-content" class="collapse show"
                                                     aria-labelledby="page-list-items"
                                                     data-parent="#add_menu_item_accordion">
                                                    <div class="card-body">
                                                        <ul class="page-list-ul">
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="1">
                                                                    {{__('Home')}}
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Home')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="2">
                                                                    @if(!empty(get_static_option('about_page_'.$default_lang.'_name'))) {{get_static_option('about_page_'.$default_lang.'_name')}} @else {{__('About')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('About')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/about'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="3">
                                                                    @if(!empty(get_static_option('service_page_'.$default_lang.'_name'))) {{get_static_option('service_page_'.$default_lang.'_name')}} @else {{__('Service')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Service')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/service'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="4">
                                                                    @if(!empty(get_static_option('work_page_'.$default_lang.'_name'))) {{get_static_option('work_page_'.$default_lang.'_name')}} @else {{__('Work')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Work')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/work'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="5">
                                                                    @if(!empty(get_static_option('team_page_'.$default_lang.'_name'))) {{get_static_option('team_page_'.$default_lang.'_name')}} @else {{__('Team')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Team')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/team'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="6">
                                                                    @if(!empty(get_static_option('faq_page_'.$default_lang.'_name'))) {{get_static_option('faq_page_'.$default_lang.'_name')}} @else {{__('Faq')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Faq')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/faq'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="6">
                                                                    @if(!empty(get_static_option('price_plan_page_'.$default_lang.'_name'))) {{get_static_option('price_plan_page_'.$default_lang.'_name')}} @else {{__('Price Plan')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Price Plan')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/price-plan'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="8">
                                                                    @if(!empty(get_static_option('blog_page_'.$default_lang.'_name'))) {{get_static_option('blog_page_'.$default_lang.'_name')}} @else {{__('Blog')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Blog')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/blog'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="9">
                                                                    @if(!empty(get_static_option('contact_page_'.$default_lang.'_name'))) {{get_static_option('contact_page_'.$default_lang.'_name')}} @else {{__('Contact')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Contact')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/contact'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="9">
                                                                    @if(!empty(get_static_option('career_with_us_page_'.$default_lang.'_name'))) {{get_static_option('career_with_us_page_'.$default_lang.'_name')}} @else {{__('Career With Us')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Career With Us')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/career-with-us'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="9">
                                                                    @if(!empty(get_static_option('events_page_'.$default_lang.'_name'))) {{get_static_option('events_page_'.$default_lang.'_name')}} @else {{__('Events')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Events')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/events'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            <li>
                                                                <label class="menu-item-title">
                                                                    <input type="checkbox" class="menu-item-checkbox"
                                                                           value="9">
                                                                    @if(!empty(get_static_option('knoledgebase_page_'.$default_lang.'_name'))) {{get_static_option('knoledgebase_page_'.$default_lang.'_name')}} @else {{__('Knowledgebase')}}  @endif
                                                                </label>
                                                                <input type="hidden" class="menu-item-title"
                                                                       value="{{__('Knowledgebase')}}">
                                                                <input type="hidden" class="menu-item-url"
                                                                       value="{{'[url]/knoledgebase'}}">
                                                                <input type="hidden" class="menu-item-db-id" value="">
                                                            </li>
                                                            @foreach($all_page as $data)
                                                                <li>
                                                                    <label class="menu-item-title">
                                                                        <input type="checkbox"
                                                                               class="menu-item-checkbox" value="9">
                                                                        @if(in_array($data->title,$static_page_list)) {{get_static_option(strtolower(str_replace(' ','_',$data->title)).'_page_'.$default_lang.'_name')}} @else {{__($data->title)}} @endif
                                                                    </label>
                                                                    <input type="hidden" class="menu-item-title"
                                                                           value="{{$data->title}}">
                                                                    <input type="hidden" class="menu-item-url"
                                                                           value="{{'[url]/p/'.$data->id.'/'.Str::slug($data->title)}}">
                                                                    <input type="hidden" class="menu-item-db-id"
                                                                           value="{{$data->id}}">
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="form-group">
                                                            <button type="button" id="add_page_to_menu"
                                                                    class="btn btn-primary btn-xs mt-4 pr-4 pl-4">{{__('Add To Menu')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="custom-links">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#custom-links-content"
                                                                aria-expanded="false"
                                                                aria-controls="custom-links-content">
                                                            {{__('Custom Links')}}
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="custom-links-content" class="collapse"
                                                     aria-labelledby="custom-links"
                                                     data-parent="#add_menu_item_accordion">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="custom_url"><strong>{{__("URL")}}</strong></label>
                                                            <input type="text" name="custom_url" id="custom_url"
                                                                   class="form-control"
                                                                   placeholder="{{__('https://')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="custom_label_text"><strong>{{__("Link Text")}}</strong></label>
                                                            <input type="text" name="custom_label_text"
                                                                   id="custom_label_text" class="form-control"
                                                                   placeholder="{{__('label text')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" id="add_custom_links"
                                                                    class="btn btn-primary btn-xs mt-4 pr-4 pl-4">{{__('Add To Menu')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                   <div class="menu-structure-wrapper">
                                       <div class="card">
                                           <div class="card-header">
                                               <h3 class="title">{{__('Menu Structure')}}</h3>
                                           </div>
                                           <div class="card-body">
                                               <section id="drop_down_menu_builder_wrapper">
                                                   <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
                                                       @if(!empty($page_post->content))
                                                           @php
                                                                $cc = 0;
                                                                $parent_item_count = 0;
                                                               $menu_content = json_decode($page_post->content);
                                                           @endphp
                                                       @foreach($menu_content as $data)
                                                               @php
                                                                   if ($cc > 0 && $cc == $parent_item_count){ print '</ol>'; $cc = 0; }
                                                                  if (!empty($data->parent_id) && $data->depth > 0){
                                                                       if  ($cc == 0){
                                                                           print '<ol>';
                                                                           $parent_item_count = get_child_menu_count($menu_content,$data->parent_id);
                                                                       }else{  print '</li>'; }
                                                                   }else{ print '</li>'; }

                                                               @endphp
                                                           <li style="display: list-item;"
                                                               class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"
                                                               id="menuItem_{{$data->id}}" data-title="{{$data->menuTitle}}" data-url="{{$data->menuUrl}}">
                                                               <div class="menuDiv">
                                                                   <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>
                                                                   <span>
                                                                       <span data-id="1" class="itemTitle">
                                                                           @if(in_array($data->menuTitle,$static_page_list)) {{get_static_option(strtolower(str_replace(' ','_',$data->menuTitle)).'_page_'.$default_lang.'_name')}} @else {{__($data->menuTitle)}} @endif
                                                                       </span>
                                                                       <span title="Click to delete item." data-id="{{$data->id}}" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>
                                                                   </span>
                                                               </div>

                                                           @php if (!empty($data->parent_id) && $data->depth > 0){ $cc++;} @endphp
                                                       @endforeach
                                                       @else
                                                           <li style="display: list-item;"
                                                               class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"
                                                               id="menuItem_1" data-title="{{__('Home')}}" data-url="{{'[url]'}}">
                                                               <div class="menuDiv">
                                                                   <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>
                                                                   <span>
                                                               <span data-id="1" class="itemTitle">{{__('Home Page')}}</span>
                                                               <span title="Click to delete item." data-id="1" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>
                                                           </span>
                                                               </div>
                                                           </li>
                                                       @endif
                                                   </ol>
                                               </section><!-- END #demo -->
                                           </div>
                                       </div>
                                   </div>
                                    <div class="form-group">
                                        <button type="submit" id="menu_structure_submit_btn" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                    </div>
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
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script src="{{asset('assets/backend/js/jquery.mjs.nestedSortable.js')}}"></script>
    <script>
        $(document).ready(function () {

            var ns = $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: 2,
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false,
            });

            $(document).on('click','.disclose', function () {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
                $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
            });

            $(document).on('click','.deleteMenu',function () {
                var id = $(this).attr('data-id');
                $('#menuItem_' + id).remove();
            });


            $(document).on('click', '#add_custom_links', function (e) {
                e.preventDefault();
                var customUrl = $('#custom_url').val();
                var labelText = $('#custom_label_text').val();
                if(customUrl =='' ){ $('#custom_url').addClass('error');}
                if(labelText =='' ){ $('#custom_label_text').addClass('error'); }

                if(customUrl !='' && labelText != ''){
                    var menuLength = $('ol.sortable li').length + 1;
                    $('#drop_down_menu_builder_wrapper ol.sortable').append('<li style="display: list-item;"\n' +
                        'class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"\n' +
                        'id="menuItem_'+menuLength+'" data-title="'+labelText+'" data-url="'+customUrl+'">\n' +
                        '<div class="menuDiv">\n' +
                        '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>\n' +
                        '<span>\n' +
                        '<span data-id="2" class="itemTitle">'+labelText+'</span>\n' +
                        '<span title="Click to delete item." data-id="'+menuLength+'" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>\n' +
                        '</span>\n' +
                        '</div>\n' +
                        '</li>');
                    $('#custom_url').removeClass('error');
                    $('#custom_label_text').removeClass('error');
                }

            });
            $(document).on('click', '#add_page_to_menu', function (e) {
                e.preventDefault();

                var selectedMenuItem = $('#page-list-items-content ul li').find('input[type="checkbox"]:checked');
                if (selectedMenuItem.length > 1){
                    $.each(selectedMenuItem,function (index,value) {
                        var el = $(this);
                        el.attr('checked',false);
                        var menuLength = $('ol.sortable li').length + 1;
                        var selectedMenuTitle = el.parent().next().val();
                        var selectedMenuUrl = el.parent().next().next().val();
                        var selectedMenuDbId = el.parent().next().next().next().val();
                        $('#drop_down_menu_builder_wrapper ol.sortable').append('<li style="display: list-item;"\n' +
                            'class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"\n' +
                            'id="menuItem_'+menuLength+'" data-title="'+selectedMenuTitle+'" data-url="'+selectedMenuUrl+'">\n' +
                            '<div class="menuDiv">\n' +
                            '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>\n' +
                            '<span>\n' +
                            '<span data-id="2" class="itemTitle">'+selectedMenuTitle+'</span>\n' +
                            '<span title="Click to delete item." data-id="'+menuLength+'" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>\n' +
                            '</span>\n' +
                            '\n' +
                            '</div>\n' +
                            '</li>');
                    })
                }else{
                    selectedMenuItem.attr('checked',false);
                    var selectedMenuTitle = selectedMenuItem.parent().next().val();
                    var selectedMenuUrl = selectedMenuItem.parent().next().next().val();
                    var selectedMenuDbId = selectedMenuItem.parent().next().next().next().val();
                    var menuLength = $('ol.sortable li').length + 1;
                    $('#drop_down_menu_builder_wrapper ol.sortable').append('<li style="display: list-item;"\n' +
                        'class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"\n' +
                        'id="menuItem_'+menuLength+'" data-title="'+selectedMenuTitle+'" data-url="'+selectedMenuUrl+'">\n' +
                        '<div class="menuDiv">\n' +
                        '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>\n' +
                        '<span>\n' +
                        '<span data-id="2" class="itemTitle">'+selectedMenuTitle+'</span>\n' +
                        '<span title="Click to delete item." data-id="'+menuLength+'" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>\n' +
                        '</span>\n' +
                        '\n' +
                        '</div>\n' +
                        '</li>');
                }

            });

            $(document).on('click','#menu_structure_submit_btn',function(e){
               e.preventDefault();
                var arrr = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                arrr.shift();
                $('#menu_content').val(JSON.stringify(arrr));
                console.log(arrr);
                $('#menu_update_form').submit();
            });

        });
    </script>
@endsection
