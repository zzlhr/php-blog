@foreach($commends as $commend)
<article style="margin-left: 30px; margin-right: 30px; height: 100%;">
    <div>
        <p class="h3"><a href="{{$domain}}{{$commend->article_url}}">{{$commend->article_title}}</a></p>
        <p class="h4" style="color: #666666; line-height: 30px;">{{$commend->article_describe}}</p>
    </div>
    <div class="row">
        <div class="col-lg-2 clearfix">
            <p><a href="#">{{$commend->create_time}}</a></p>
            <div style="width:100%;">
                <p>
                    @foreach($commend->article_keyword as $keyword)
                    <label>{{$keyword}}</label>&nbsp;&nbsp;
                    @endforeach
                </p>
            </div>
        </div>
        <div class="col-lg-10">
            <!-- 内容 -->


            <div class="entry-content">
                {!! $commend->article_text !!}
            </div>
        </div>
    </div>
</article>
@endforeach