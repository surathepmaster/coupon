@extends('layout.app')

@section('content')

<div id="content"> 
    <!-- Topbar -->
    @include('layout.topbar')
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">บันทึกรายการคูปองลูกค้าทั้งหมด</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead  class="thead-dark">
                            <tr class="text-center">
                                <th>OrderNo</th>
                                <th>CustomeName</th>
                                <th>CustomerMobile</th>
                                <th>PackageCode</th>
                                <th>ระยะเวลาเริ่มต้น</th>
                                <th>ระยะเวลาสิ้นสุด</th>
                            </tr>
                        </thead>                   
                        

                        <tbody>
                            @foreach($data as $item) 
                            <tr class="table">                              
                                <td class="text-center">{{$item->OrderNo}}</td>
                                <td class="text-center">{{$item->CustomeName}}</td>
                                <td class="text-center">{{$item->CustomerMobile}}</td>
                                <td class="text-center">{{$item->PackageCode}}</td>
                                <td class="text-center">{{$item->PackageExpired}}</td>
                                <td class="text-center">{{$item->PackageExpiredTo}}</td>                                
                            </tr>
                            @endforeach  
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <script>
     
    </script>

</div>
@endsection
