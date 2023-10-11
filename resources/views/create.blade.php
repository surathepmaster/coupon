@extends('layout.app')

@section('content')

<div id="content"> 
    <!-- Topbar -->
    @include('layout.topbar')
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-6 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">เพิ่มคูปอง</h6>
                    </div>
                    <div class="card-body">                   
                        {{-- <form action="{{ env('url')}}coupon" method="POST" enctype="multipart/form-data"> --}}
                         @if(session('status'))
                            <div class="alert alert-success">
                                {{session('status')}}
                            </div>
                        @endif

                        @if(session('status'))
                            <script>
                                Swal.fire({
                                    title: 'บันทึกข้อมูลไม่สำเร็จ',
                                    text: 'คุณเพิ่มคูปองให้ลูกค้าในระบบแล้ว',
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง'
                                });
                            </script>
                        @endif
                     

                        @if (Session::has('error'))
                        <script>
                            Swal.fire({
                                title: 'บันทึกข้อมูลไม่สำเร็จ',
                                text: 'คุณเพิ่มคูปองให้ลูกค้าในระบบแล้ว',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        </script>
                                {{ Session::get('error') }}           
                        @endif


                        <form action="{{env('url')}}coupon" method="POST" enctype="multipart/form-data" id = "myForm">
                            @csrf 
                            
                            @error('PackageDetail')
                                <script>
                                    Swal.fire({
                                        title: 'เพิ่มคูปองไม่สำเร็จ',
                                        text: 'คุณเพิ่มคูปองในระบบแล้ว',
                                        icon: 'error',
                                        confirmButtonText: 'ตกลง'
                                    });
                                </script>                                 
                            @enderror

                            <div class="row mb-3">
                              <label for="inputEmail3" class="col-sm-4 col-form-label">รายการแลกของ</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="PackageDetail" name="PackageDetail" required>
                                </div>                           
                            </div>

                            @error('PackageCode')
                                <script>
                                    Swal.fire({
                                        title: 'เพิ่มคูปองไม่สำเร็จ',
                                        text: 'คุณเพิ่มแพ๊คเกจในระบบแล้ว',
                                        icon: 'error',
                                        confirmButtonText: 'ตกลง'
                                    });
                                </script>                                      
                            @enderror
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">แพ๊คเกจ</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="PackageCode" name="PackageCode" required>
                                </div>                              
                            </div>

                              <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">ส่วนลด</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="PackageDiscount" name="PackageDiscount" required>
                                </div>
                               
                              </div>

                              <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">แต้มที่ใช้แลก</label>
                                <div class="col-sm-8">
                                  <input type="number" class="form-control" id="PackagePoint" name="PackagePoint" required>
                                </div>
                           
                              </div>

                              <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">ระยะเวลาการใช้คูปอง (เดือน)</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="PackageExpired" name="PackageExpired" required>
                                </div>
                               
                              </div>                              
                            <button type="submit" class="btn btn-success">บันทึก</button> 
                            <button type="button" class="btn btn-danger" value = "Reset data" onClick = "fun()">ยกเลิก</button>
                   
                          </form> 
                          @if (Session::has('message'))                          
                          <script>
                              Swal.fire(
                                    'บันทึกคูปองสำเร็จ',
                                    'You clicked the button!',
                                    'success'
                                    )
                          </script>
                          @endif  
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales Example -->
      

    </div>
    <!-- /.container-fluid -->

    

</div>
@endsection
