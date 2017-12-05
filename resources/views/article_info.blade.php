<article style="margin-left: 30px; margin-right: 30px; height: 100%;">
    <div>
        <p class="h3"><a href="article/{{$article->id}}">{{$article->article_title}}</a></p>
        <p class="h4" style="color: #666666; line-height: 30px;">{{$article->article_describe}}</p>
    </div>
    <div class="row">
        <div class="col-lg-2 clearfix">
            <p><a href="#">{{$article->create_time}}</a></p>
            <div style="width:100%;">
                <p>
                    @foreach($article->article_keyword as $keyword)
                    <label>{{$keyword}}</label>&nbsp;&nbsp;
                    @endforeach
                </p>
            </div>
        </div>
        <div class="col-lg-10">
            <!-- 内容 -->


            <div class="entry-content">
                {!! $article->article_text !!}
            </div>
        </div>
    </div>
</article>