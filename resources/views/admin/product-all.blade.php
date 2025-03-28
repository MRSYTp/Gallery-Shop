@extends('layout.admin.master')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 mt-4">
          <div class="col-12">
            <h1 class="m-0 text-dark">
                <a class="nav-link drawer" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                محصولات
                <a class="btn btn-primary float-left text-white py-2 px-4" href="{{ route('admin.products.add')}}">افزودن محصول جدید</a>
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @include('errors.message')
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">لیست محصولات</h3>

                          <div class="card-tools">
                            <form action="">
                              <div class="input-group input-group-sm" style="width: 150px;">
                                  <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                  </div>
                              </div>
                            </form>
                          </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="table table-striped table-valign-middle mb-0">
                          <table class="table table-hover mb-0">
                              <tbody>
                              <tr>
                                  <th>آیدی</th>
                                  <th>عنوان</th>
                                  <th>دسته بندی</th>
                                  <th>مالک طرح</th>
                                  <th>توضیحات</th>
                                  <th>لینک دمو</th>
                                  <th>لینک دانلود</th>
                                  <th>قیمت</th>
                                  <th>تاریخ ایجاد</th>
                                  <th>عملیات</th>
                              </tr>
                              @foreach ($products as $product)
                              <tr>
                                  <td>{{$product->id}}</td>
                                  <td>
                                      <img src="/storage/{{ $product->thumbnail_url }} " class="product_img">
                                      {{$product->title}}
                                  </td>
                                  <td>{{$product->category->title}}</td>
                                  <td>{{$product->user->name}}</td>
                                  <td>{!!substr($product->description , 0 , 20)!!}...</td>
                                  <td>
                                      <a href="{{route('admin.products.downloadDemo' , $product->id) }}" class="btn btn-default btn-icons" title="لینک دمو"><i class="fa fa-link"></i></a>
                                  </td>
                                  <td>
                                      <a href="{{route('admin.products.downloadSource' , $product->id) }}" class="btn btn-default btn-icons" title="لینک دانلود"><i class="fa fa-link"></i></a>
                                  </td>
                                  <td>{{number_format($product->price)}} تومان</td>
                                  <td>{{(new Hekmatinasser\Verta\Verta($product->created_at))->format('Y/m/d')}}</td>
                                  <td>
                                      <a href="{{ route('admin.products.edit' , $product->id)}}" class="btn btn-default btn-icons"><i class="fa fa-edit"></i></a>
                                      <form action="{{ route('admin.products.delete' , $product->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-default btn-icons"><i class="fa fa-trash"></i></button>
                                      </form>
                                  </td>
                              </tr>
                              @endforeach
                              </tbody></table>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                  <div class="d-flex justify-content-center">
                      <ul class="pagination mt-3">
                        {{$products->links()}}
                      </ul>
                  </div>
              </div>
          </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
