<!DOCTYPE html>
<html>
<head>
    <title>blog</title>
    {{--{*{{template "public_header.tpl" .}}*}--}}
    {{--{*{{template "blog_style.tpl" .}}*}--}}

    @include('public_header')
    @include('blog_style')


</head>

<body>
<div class="container-fluid">
    <div class="blog-left-nav hidden-xs col-lg-3 center-block">

        <div class="clearfix">
            <div class="center-block col-lg-12">
                {{--<p>{{ json_encode($site) }}</p>--}}
                <p class="h2" style="text-align: center;">{{$site[0]->website_title}}</p>
                <p class="text-muted" style="text-align: center;">{{$site[0]->website_subhead}}</p>
            </div>
        </div>

        <div class="blog-left-content">
            <div class="blog-search">

                <div class="col-lg-12">
                    <div class="input-group">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Search</button>
                          </span>
                        <input type="text" class="form-control" placeholder="Search for...">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div>

            <div class="">
                <div class="blog-left-title">
                    <label class="h4">最近发表</label>
                </div>
                <ul class="">
                    <li><a href="#">测试文章列表1</a></li>
                    <li><a href="#">测试文章列表2</a></li>
                    <li><a href="#">测试文章列表3</a></li>
                    <li><a href="#">测试文章列表4</a></li>
                    <li><a href="#">测试文章列表5</a></li>
                    <li><a href="#">测试文章列表1</a></li>
                    <li><a href="#">测试文章列表2</a></li>
                    <li><a href="#">测试文章列表3</a></li>
                    <li><a href="#">测试文章列表4</a></li>
                    <li><a href="#">测试文章列表5</a></li>
                </ul>
            </div>

            <div>
                <div class="blog-left-title">
                    <label class="h4">按时间分类</label>
                </div>
                <ul class="">
                    <li><a href="#">2017-01(20)</a></li>
                    <li><a href="#">2017-02(20)</a></li>
                    <li><a href="#">2017-03(20)</a></li>
                    <li><a href="#">2017-04(20)</a></li>
                    <li><a href="#">2017-05(20)</a></li>
                    <li><a href="#">2017-06(20)</a></li>
                    <li><a href="#">2017-07(20)</a></li>
                    <li><a href="#">2017-08(20)</a></li>
                    <li><a href="#">2017-09(20)</a></li>
                </ul>
            </div>
            <div>
                <div class="blog-left-title">
                    <label class="h4">标签</label>
                </div>
                <div class="blog-left-title">
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                    <a class="btn btn-default btn-xs" href="#">apache</a>
                </div>
            </div>


            <div>
                <div class="blog-left-title">
                    <label class="h4">友情链接</label>
                </div>
                <div class="blog-left-title">
                    @foreach($friends as $friend)
                    <a href="{{$friend->link_url}}">{{$friend->link_value}}</a>
                    @endforeach
                </div>
            </div>

            <!--<div class="blog-foot col-lg-9 col-xs-12"  style="text-align: center;">-->
            <!--<p>刘浩然的博客<br /><a href="#">京公网安备11000002000001号 </a></p>-->
            <!--</div>-->
        </div>
    </div>
    <div class="blog-right-nav col-lg-9 col-xs-12 clearfix">
        @if($type === 1)
            @include('article_list')
        @elseif($type === 2)
            @include('article_info')
        @endif
    </div>
</div>
</body>
</html>
