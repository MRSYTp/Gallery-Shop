<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | صفحه ورود</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/iCheck/square/blue.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="/admin/dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="/admin/dist/css/custom-style.css">
</head>
<body class="hold-transition login-page">
    
<div class="login-box" style="    width: 400px;">
    <div class="login-title">
        درگاه پرداخت شبیه سازی
        
    </div>
    <!-- /.login-logo -->
    
    <div class="card">
        
        <div class="card-body login-card-body">
            @include('errors.message')
            <form action="{{route('frontend.payment.callback')}}" method="post">
                @csrf
                <input name="amount" type="text" class="form-control mb-2" placeholder="قیمت (تومان)">
                <h6>
                    <p>قیمت خرید خود را وارد کنین تا پرداخت تایید بشه.</p>
                    
                    <b>قیمت : {{number_format($totalPrice)}} تومان</b>
                    <br>
                    <br>
                    <p class="text-danger">توجه : اگر اشتباه وارد کنین پرداخت ناموفق میشود.</p>
                </h6>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">تایید</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="/admin/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
