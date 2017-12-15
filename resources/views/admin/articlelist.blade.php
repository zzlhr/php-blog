@include('admin.publicheader')
    <section class="content-header">
        <h1>
            文章列表
            <small>{{$name}} | 后台管理系统</small>
            <div class="pull-right">
                <a href="articleadd.html" class="btn btn-block btn-success">添加文章</a>
            </div>
        </h1>

    </section>


    <!-- Main content -->
    <section class="content">

        <ol class="breadcrumb" style="margin-bottom: 5px;">
            <li><a href="/admin/index.html"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">文章列表</li>
        </ol>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-default collapsed-box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">高级查询</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="articlelist.html" method="get" class="row">
                            <div class="col-xs-3 form-group">
                                <label for="articleName" class="col-sm-3 control-label">文章名</label>
                                <input type="text" name="articleName" id="articleName" class="form-control col-sm-9" placeholder="请输入文章名关键字">
                            </div>
                            <div class="col-xs-3 form-group">
                                <label for="keyword" class="col-sm-3 control-label">关键字</label>
                                <input type="text" name="keyword" id="keyword" class="form-control col-sm-9" placeholder="请输入关键字">
                            </div>
                            <div class="col-xs-3 form-group">
                                <label for="clazz" class="col-sm-3 control-label">分类</label>
                                <select name="clazz" id="clazz" class="form-control">
                                    <option value="">请选择</option>
                                    @foreach($clazz_dorpdown as $clazzd)
                                        <option value="{{$clazzd->class_name}}">{{$clazzd->class_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-3 form-group">
                                <input style="margin-top: 17px;" class="btn btn-success pull-right" type="submit" value="查询">
                            </div>
                        </form>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="data1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="col-lg-1">文章名</th>
                                    <th class="col-lg-1">分类</th>
                                    <th class="col-lg-2">关键字</th>
                                    <th class="col-lg-3">描述</th>
                                    <th class="col-lg-1">点击数</th>
                                    <th class="col-lg-1">状态</th>
                                    <th class="col-lg-2">更新时间</th>
                                    <th class="col-lg-1">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        <td>{{$article->article_title}}</td>
                                        <td>{{$article->article_class}}</td>
                                        <td>{{$article->article_keyword}}</td>
                                        <td>{{$article->article_describe}}</td>
                                        <td>{{$article->article_click}}</td>
                                        <td>@if($article->article_status==0)
                                                显示
                                            @else
                                                隐藏
                                            @endif
                                        </td>
                                        <td>{{$article->update_time}}</td>
                                        <td>
                                            <a class="btn btn-xs" href="articleinfo.html?id={{$article->id}}">详情</a>
                                            <a class="btn btn-xs" href="articleupdate.html?id={{$article->id}}">修改</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--<div class="pagination" id="pages"></div>--}}
                            {{$articles->links()}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@include('admin.publicfoot')
<script src="jqPaginator-1.2.1/dist/jqpaginator.min.js"></script>
<script>

</script>
