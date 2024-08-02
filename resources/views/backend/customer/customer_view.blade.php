@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">صفحة عرض تفاصيل زبون</h4><br>

                            <form method="post" action="{{ route('customer.update') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $customer->id }}">


                                <div class="row mb-4 mt-3 ">
                                    <div class="form-group col-sm-10 d-flex justify-content-center">
                                        <h2>{{ $customer->name }}</h2>
                                    </div>

                                </div>
                                <!-- end row -->
                                <div class="row mb-3 mt-3">

                                    <h2>ديون الزبون</h2>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>تاريخ الفاتورة</th>
                                                <th>المبلغ المستحق</th>
                                                <th>التاريخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($creditPayments as $payment)
                                                <tr>
                                                    <td>{{ $payment->invoice_id }}</td>
                                                    <td>{{ $payment->due_amount }}</td>
                                                    <td>{{ $payment->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                <div>
                                    <h2>مدفوعات الزبون</h2>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>تاريخ الفاتورة</th>
                                                <th>المبلغ المستحق</th>
                                                <th>التاريخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paidPayments as $payment )
                                                <tr>
                                                    <td>{{ $payment->invoice_id }}</td>
                                                    <td>{{ $payment->due_amount }}</td>
                                                    <td>{{ $payment->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>







                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script type="text/javascript">
     
    </script>
@endsection
