<article style="margin-left: 30px; margin-right: 30px;">
    <div>
        <p class="h3">{{$article->article_title}}</p>
        <p><a href="#">{{$article->create_time }}</a></p>
        <p class="h4" style="color: #666666; line-height: 30px;">{{$article->article_describe}}</p>
    </div>
    <div class="row">
        <div class="col-lg-2 clearfix">
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
@include('UEditor::head')
<div style="margin-left: 30px; margin-right: 30px;">
    <hr />
    <h4>评论：</h4>


    <form action="comment" method="post" id="comment">

        <input type="text" class="hidden" name="fid" value="0">
        <input type="text" class="hidden" name="id" value="{{$article->id}}" />
        <div class="from-group">
            <lable for="comment_name">请输入昵称：</lable>
            <input class="form-control" type="text" id="comment_name" name="name" placeholder="昵称"/>
        </div>

        <br />

        <div>
            <lable>留言内容：</lable>
            <script id="container" name="content" type="text/plain"></script>
        </div>

        <br />

        <input type="submit" class="btn btn-info pull-right" value="发布留言" />
        <br />

    </form>
    <hr />

    <div>
        @foreach($comments as $comment)
        <ul class="list-group">
            <li class="list-group-item" style="list-style-type: none;">
                <div>
                    <div>
                        <img class="blog-comment-header" style="width: 40px;height: 40px;" src="https://qlogo4.store.qq.com/qzone/2388399752/2388399752/100?1512048993" alt="头像" class="img-circle">
                        <b><a href="#">{{$comment->comment_name}}</a></b>评论到：
                        <div class="pull-right">{{$comment->create_time}}</div>
                    </div>

                    <div style="margin-left: 40px;">
                        {!! $comment->comment_text !!}
                    </div>
                    {{--<div class="pull-right"><button class="btn btn-sm btn-info">回复</button></div>--}}
                    <br>
                    {{--<hr />--}}
                    {{--<ul class="list-group">--}}
                        {{--<li class="list-group-item">张三：Cras justo odio<div class="pull-right">2017-12-12 12:00:59</div></li>--}}
                        {{--<li class="list-group-item">张三：Dapibus ac facilisis in<div class="pull-right">2017-12-12 12:00:59</div></li>--}}
                        {{--<li class="list-group-item">张三：Morbi leo risus<div class="pull-right">2017-12-12 12:00:59</div></li>--}}
                        {{--<li class="list-group-item">张三：Porta ac consectetur ac<div class="pull-right">2017-12-12 12:00:59</div></li>--}}
                        {{--<li class="list-group-item">张三：Vestibulum at eros<div class="pull-right">2017-12-12 12:00:59</div></li>--}}
                    {{--</ul>--}}
                </div>
            </li>
        </ul>
        @endforeach
    </div>



</div>

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });

</script>