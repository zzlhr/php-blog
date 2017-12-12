<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>管理员登录</title>
    @include('public_header')
</head>
<body>
<form action="login.php" method="post">
    <div class="mycenter">
        <div class="mysign">
            <div class="col-lg-11 text-center text-info">
                <h2>请登录</h2>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="username" placeholder="请输入账户名" required autofocus/>
            </div>
            <div class="col-lg-10"></div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="password" placeholder="请输入密码" required autofocus/>
            </div>
            <div class="col-lg-10"></div>
            <div class="col-lg-10 mycheckbox checkbox">
                <input type="checkbox" class="col-lg-1">记住密码</input>
            </div>
            <div class="col-lg-10"></div>
            <div class="col-lg-10">
                <button type="button" class="btn btn-success col-lg-12">登录</button>
            </div>
        </div>
    </div>
</form>
</body>
</html>