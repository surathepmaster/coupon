@extends('layout.app')

@section('content')

<div id="content"> 
    <!-- Topbar -->
    
    @include('layout.topbar')
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        {{-- @if(session('status'))
             <div class="alert alert-danger">
                {{session('status')}}
            </div>
        @endif --}}

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

        @if (Session::has('warning'))
            <script>
                Swal.fire({
                    title: 'คุณยังไม่เพิ่มคูปอง',
                    text: 'กรอกเลือกคูปองจากตาราง',
                    icon: 'warning',
                    confirmButtonText: 'ตกลง'
                });
            </script>
            {{ Session::get('warning') }}   
        @endif

        @if (Session::has('success'))
                <script>
                    Swal.fire({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        text: 'คุณเพิ่มคูปองในระบบแล้ว',
                        icon: 'success',
                        confirmButtonText: 'ตกลง'
                    });
                </script>
            {{ Session::get('success') }}           
        @endif
   
        
        <form action="{{ env('weburl') }}savedata" id="formSubmit" method="POST" enctype="multipart/form-data">
            @csrf  
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">หน้ารายการแลกของ</h6>
                        </div>

                        <div class="card-body">     
                                
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Cord Reference :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="Cord_Reference">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">OrderNo *** :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="orderno" id="orderno" placeholder="" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Regist Date :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="currentdate"
                                            placeholder="" readonly>
                                    </div>
                                </div>

                                @error('hncard')
                                <script>
                                    Swal.fire({
                                        title: 'ไม่พบข้อมูล',
                                        text: 'กรอกข้อมูลในช่อง HNIDCard*',
                                        icon: 'question',
                                        confirmButtonText: 'ตกลง'
                                    });
                                </script>
                                @enderror  

                                @error('package')
                                <script>
                                    Swal.fire({
                                        title: 'คุณยังไม่เพิ่มคูปอง',
                                        text: 'กรอกเลือกคูปองจากตาราง',
                                        icon: 'warning',
                                        confirmButtonText: 'ตกลง'
                                    });
                                </script>
                                @enderror  

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">HNIDCard* :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="hncard" name="hncard">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">ชื่อ-สกุล :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="fullname" name="fullname">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">เบอร์ติดต่อ :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>

                            
                                {{-- <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-success" onclick="">ค้นหา</button> 
                                        <button type="button" class="btn btn-danger" value = "Reset data" onClick="Clear()">ยกเลิก</button>
                                    </div>
                                </div>  --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <!-- Illustrations -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text">คูปอง Cord Reference :</h6>
                        </div>
                        <div class="card-body">   
                                             
                            <table id="" class="table table-bordered table-striped">
                                <thead class="thead-dark" id="">
                                    <tr>      
                                        <th scope="col">#</th>                              
                                        <th scope="col">รายการ</th>
                                        <th scope="col">ส่วนลด</th>                                   
                                        <th scope="col">ระยะเวลา</th>                                   
                                    </tr>
                                </thead>
                                <div id="total-data"></div>                            
                            </table>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text">เพิ่มคูปอง</h6>
                        </div>
                    
                        <div class="card-body">
                            <table id="AddCoupou" class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>                                    
                                        <th scope="col">รายการ</th>
                                        <th scope="col">ส่วนลด</th>
                                        <th scope="col">แต้มที่ใช้</th>
                                        <th scope="col">ระยะเวลา</th>
                                        <th scope="col">จัดการ</th>
                                    </tr>
                                </thead>

                                <tfoot>

                                    <tr>
                                        <th>คะแนนรวม</th>
                                        <th></th>
                                        <th>
                                            <input id="totalPoint" type="hidden" name="totalPoint">
                                            <span id="demo"></span>                                        
                                        </th>
                                        <th>คะแนน</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success float-right ml-2" onclick="submitForm()">บันทึก</button>
                        <button type="button" class="btn btn-danger float-right ml-2" value = "Resetdata" onclick="clearInput('hncard','fullname','phone')"> ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
       

        <!-- DataTales Example -->       


        <div class="card shadow mb-4">          
            {{-- <div class="card-header">
                <div class="bs-example">
                    <div class="bg-light clearfix">
                        <span>

                        </span>
                        <button type="button" class="btn btn-success float-right ml-2" onclick="SaveData()"> บันทึก</button>
                        <button type="button" class="btn btn-danger float-right ml-2" value = "Resetdata" onclick="clearInput('hncard','fullname','phone')"> ยกเลิก</button>

                    </div>
                </div>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">

                    
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead  class="thead-dark">
                            <tr class="text-center">
                                <th>รายการแลกของ</th>
                                <th>แพ็กเกจ</th>
                                <th>ส่วนลด</th>
                                <th>แต้มที่ใช้แลก</th>
                                <th>ระยะเวลาการใช้คูปอง</th>
                                <th>เลือก</th>
                            </tr>
                        </thead>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot> --}}
                               
                                <tbody>
                                    @foreach($data as $item) 
                                    <tr class="table">                              
                                        <td name="$PackageDetail" id="$PackageDetail">{{$item->PackageDetail}}</td>
                                        <td  class="text-center name="$PackageCode" id="$PackageCode">{{$item->PackageCode}}</td>
                                        <td  class="text-center name="$PackageDiscount" id="$PackageDiscount">{{$item->PackageDiscount}}</td>
                                        <td  class="text-center name="$PackagePoint" id="$PackagePoint">{{$item->PackagePoint}}</td>
                                        <td  class="text-center name="$PackageExpired" id="$PackageExpired">{{$item->PackageExpired}}&nbsp;เดือน</td>                               
                                        <td  class="text-center"> 
                                           <button type="button" class="btn btn-success" onclick="addRow('{{$item->PackageDetail}}','{{$item->PackageCode}}','{{$item->PackageDiscount}}','{{$item->PackagePoint}}','{{$item->PackageExpired}}','{{$item->PackageCode}}');">เลือก</button>                                                                   
                                        </td>
                                    </tr>
                                    @endforeach  
                                </tbody>
                                 
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- <script>
    @if(session('success'))
        // Display a JavaScript alert when the success message is present
        window.alert("{{ session('success') }}");
    @endif
</script> --}}
@endsection 



