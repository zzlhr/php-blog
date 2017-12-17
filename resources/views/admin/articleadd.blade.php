<!-- 添加文章 -->

@include('admin.publicheader')
<section class="content-header">
    <h1>
        首页
        <small>{{$name}} | 后台管理系统</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <ol class="breadcrumb" style="margin-bottom: 5px;">
        <li><a href="/admin/index.html"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{$title}}</li>
    </ol>



    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">添加文章</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post">
            <div class="box-body">
                <input class="hidden" type="text" name="id" value="{{ $id }}" />
                <div class="form-group col-lg-6" style="padding-left: 0px;">
                    <label for="title">文章标题</label>
                    <input type="text" name="title" class="form-control" value="@if($type != 1){{$article->article_title}}@endif" id="article_title" placeholder="文章标题">
                </div>

                <div class="form-group col-lg-6" style="padding-right: 0px;">
                    <label for="class">文章分类</label>
                    <select class="form-control" name="class" value="@if($type != 1){{$article->article_class}}@endif">
                            @foreach($class as $cs)
                            <option value="{{$cs->class_name}}">{{$cs->class_name}}</option>
                            @endforeach
                    </select>
                </div>

                <div class="form-group" >
                    <label for="keyword">文章关键字(多个关键字用「,」隔开)</label>
                    <input type="text" name="keyword" class="form-control" value="@if($type != 1){{$article->article_keyword}}@endif" id="artice_keyword" placeholder="文章关键字">
                </div>

                <div>
                    <label for="describe">文章描述</label>
                    <textarea class="form-control" name="describe" rows="3" placeholder="文章描述 ...">@if($type != 1){{$article->article_describe}}@endif</textarea>
                </div>
                <div>
                    <label for="content">文章内容</label>
                    <script id="container" style="height: 500px;" name="content" type="text/plain">

                    </script>
                </div>

            </div>
            <!-- /.box-body -->

            @if($type!=3 && $type != 0)
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@if($type==1)发表@elseif($type==2)修改@endif</button>
                </div>
            @endif
        </form>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('admin.publicfoot')
@include('UEditor::head')
<script>
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.


        @if($type != 1)
            ue.setContent('{!! $article->article_text !!}');
        @endif
    });
</script>