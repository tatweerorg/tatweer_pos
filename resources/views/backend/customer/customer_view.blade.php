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

                        <form method="post" action="{{ route('customer.update') }}" id="myForm" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $customer->id }}">


                            <div class="row mb-4 mt-3 ">
                                <div class="form-group col-sm-10 d-flex justify-content-center">

                                    <h2>{{ $customer->name }}</h2>
                                </div>

                            </div>
                            <!-- end row -->
                            <div class="row mb-3 mt-3">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>رقم الفاتورة</th>
                                            <th>التاريخ</th>
                                            <th>المبلغ الاجمالي </th>

                                            <th>المبلغ المتبقي</th>

                                            <th>المبلغ المدفوع</th>
                                            <th> حالة الدفع </th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total_due = '0';
                                        $total_paid = '0';
                                        $total = '0';
                                        $t = '0';
                                        @endphp
                                        @foreach ($Payments as $payment)

                                        <tr>
                                            <td>{{ $payment->invoice->invoice_no	}}</td>
<td>{{ optional($payment->invoice)->date ?? 'لا يوجد تاريخ' }}</td>
                                            <td class=" bg-primary text-white text-center fw-bold fs-5">{{ $payment->total_amount }}</td>
                                            <td class=" bg-danger text-white text-center fw-bold fs-5">{{ $payment->due_amount }}</td>
                                            <td class=" bg-success text-white text-center fw-bold fs-5">{{ $payment->paid_amount }}</td>
                                            <td>
                                                @if($payment->paid_status == 'partial_paid')
                                                جزئي
                                                @elseif($payment->paid_status == 'full_paid')
                                                مدفوعة كامل
                                                @elseif($payment->paid_status == 'full_due')
                                                دين كامل
                                                @else
                                                {{ $payment->paid_status }}
                                                @endif
                                            </td>

<td>{{ $payment->created_at->addHours(2)->format('Y-m-d H:i:s') }}</td>

                                        </tr>

                                        @php
                                        $total_due += $payment->due_amount;
                                        $total_paid += $payment->paid_amount;
                                        $total += $payment->total_amount;

                                        @endphp
                                        @endforeach
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                            </td>
                                            <td class="no-line text-center">
                                                <h4 class="m-0">₪{{ $total }}</h4>
                                            </td>
                                            <td class="no-line text-center">
                                                <h4 class="m-0">₪{{ $total_due }}</h4>
                                            </td>
                                            <td class="no-line text-center">
                                                <h4 class="m-0">₪{{ $total_paid }}</h4>
                                            </td>
                                            <td class="no-line"></td>
                                        </tr>

                                    </tbody>

                                </table>



                            </div>
                                                          <div class="form-group col-sm-10 d-flex justify-content-center">

                                    <h2>دفعات الزبون</h2>
                                </div>

  <div class="row mb-3 mt-3">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>المبلغ المدفوع</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        @foreach ($partialpayments as $p)

                                        <tr>
                                            <td class="  text-center fw-bold ">{{ $p->payment_date }}</td>
                                            <td class=" bg-success text-white text-center fw-bold ">{{ $p->amount }}</td>
                                           

                                        </tr>

                                        @php
                                        $t += $p->amount;

                                        @endphp
                                        @endforeach
                                        <tr>
                                            <td class="no-line"></td>
                                            
                                            <td class="no-line text-center">
                                                <h4 class="m-0">₪{{ $t }}</h4>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>



                            </div>








                        </form>
                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                            </div>
                        </div>

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