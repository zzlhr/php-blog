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

        <input type="submit" class="btn btn-info" value="发布留言" />

    </form>
</div>

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });

</script>