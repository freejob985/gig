<div class="widget-area">
    <div class="widget widget_search">
        <form action="{{route('frontend.blog.search')}}" method="get" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="{{__('Search')}}">
            </div>
            <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="widget widget_nav_menu">
        <h2 class="widget-title">{{get_static_option('blog_page_'.get_user_lang().'_category_widget_title')}}</h2>
        <ul>
            @foreach($all_categories as $data)
                <li><a href="{{route('frontend.blog.category',['id' => $data->id,'any'=> Str::slug($data->name,'-')])}}">{{ucfirst($data->name)}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="widget widget_recent_posts">
        <h4 class="widget-title">{{get_static_option('blog_page_'.get_user_lang().'_recent_post_widget_title')}}</h4>
        <ul class="recent_post_item">
            @foreach($all_recent_blogs as $data)
                <li class="single-recent-post-item">
                    <div class="thumb">
                        @php
                            $blog_image = get_attachment_image_by_id($data->image,"thumb",false);
                        @endphp
                        @if (!empty($blog_image))
                            <img src="{{$blog_image['img_url']}}" alt="{{__($data->name)}}">
                        @endif
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="{{route('frontend.blog.single',['id' => $data->id, 'any' => Str::slug($data->title,'-')])}}">{{$data->title}}</a></h4>
                        <span class="time">{{date_format($data->created_at,'d M y')}}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
