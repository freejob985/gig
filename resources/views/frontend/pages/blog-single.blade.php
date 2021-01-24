@extends('frontend.frontend-page-master')
@php
    $post_img = null;
  $blog_image = get_attachment_image_by_id($blog_post->image,"full",false);
  $post_img = $blog_image['img_url'];
 @endphp

@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.blog.single',['id' => $blog_post->id,'any' => Str::slug($blog_post->title)])}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$blog_post->title}}" />
    <meta property="og:image" content="{{$post_img}}" />
@endsection
@section('site-title')
    {{$blog_post->title}}
@endsection
@section('page-title')
    {{$blog_post->title}}
@endsection
@section('content')
    <section class="blog-details-content-area padding-100 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-item">
                        <div class="thumb">
                            @php

                            @endphp
                            @if (!empty($blog_image))
                                <img src="{{$blog_image['img_url']}}" alt="{{__($blog_post->title)}}">
                            @endif
                        </div>
                        <div class="entry-content">
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i> {{ date_format($blog_post->created_at,'d M Y')}}</li>
                                <li><i class="fa fa-user"></i> {{ $blog_post->user->name}}</li>
                                <li>
                                    <div class="cats">
                                        <i class="fa fa-calendar"></i>
                                        <a href="{{route('frontend.blog.category',['id' => $blog_post->category->id,'any'=> Str::slug($blog_post->category->name,'-')])}}"> {{$blog_post->category->name}}</a>
                                    </div>
                                </li>
                            </ul>
                           <div class="content-area">
                               {!! $blog_post->content !!}
                           </div>
                        </div>
                        <div class="blog-details-footer"><!-- entry footer -->
                            <div class="left">
                                <ul class="tags">
                                    <li class="title">{{__('Tags:')}}</li>
                                    @php
                                        $all_tags = explode(',',$blog_post->tags);
                                    @endphp
                                    @foreach($all_tags as $tag)
                                        <li><a href="{{route('frontend.blog.tags.page',['name' => Str::slug($tag)])}}">{{$tag}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="right">
                                <ul class="social-share">
                                    <li class="title">{{__('Share:')}}</li>
                                    {!! single_post_share(route('frontend.blog.single',['id' => $blog_post->id, 'any' => Str::slug($blog_post->title,'-')]),$blog_post->title,$post_img) !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="related-post-area margin-top-40">
                        <div class="section-title ">
                            <h4 class="title ">{{get_static_option('blog_single_page_'.get_user_lang().'_related_post_title')}}</h4>
                            <div class="related-news-carousel margin-top-50">
                                @foreach($all_related_blog as $data)
                                    @if($data->id === $blog_post->id) @continue @endif
                                    <div class="single-blog-grid-01">
                                        <div class="thumb">
                                            @php
                                                $blog_image = get_attachment_image_by_id($data->image,"grid",false);
                                            @endphp
                                            @if (!empty($blog_image))
                                                <img src="{{$blog_image['img_url']}}" alt="{{__($data->name)}}">
                                            @endif
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->title}}</a></h4>
                                            <ul class="post-meta">
                                                <li><a href="#"><i class="fa fa-calendar"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                                <li><a href="#"><i class="fa fa-user"></i> {{$data->user->username}}</a></li>
                                                <li><div class="cats"><i class="fa fa-calendar"></i><a href="{{route('frontend.blog.category',['id' => $data->category->id,'any' => Str::slug($data->category->name)])}}"> {{$data->category->name}}</a></div></li>
                                            </ul>
                                            <p>{{$data->excerpt}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="disqus-comment-area margin-top-40">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var disqus_config = function () {
        this.page.url = "{{route('frontend.blog.single',['id' => $blog_post->id, 'any' => Str::slug($blog_post->title,'-')])}}";
        this.page.identifier = "{{$blog_post->id}}";
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = "https://{{get_static_option('site_disqus_key')}}.disqus.com/embed.js";
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endsection
