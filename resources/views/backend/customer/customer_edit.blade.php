@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">صفحة تعديل زبون</h4><br>

                        <form method="post" action="{{ route('customer.update') }}" id="myForm" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{$customer->id}}">


                            <div class="row mb-3 mt-3">
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{$customer->name}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">اسم الزبن</label>

                            </div>
                            <!-- end row -->

                            <div class="row mb-3 mt-3">
                                <div class="form-group col-sm-10">
                                    <input name="mobile_no" class="form-control" type="text" value="{{$customer->mobile_no}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">رقم الهاتف</label>

                            </div>
                            <!-- end row -->

                            <div class="row mb-3 mt-3">
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{$customer->email}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">الايميل</label>

                            </div>
                            <!-- end row -->

                            <div class="row mb-3 mt-3">
                                <div class="form-group col-sm-10">
                                    <input name="address" class="form-control" type="text" value="{{$customer->address}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">العنوان</label>

                            </div>
                            <!-- end row -->

                            <div class="row mb-3 mt-3">
                                <div class="form-group col-sm-10">
                                    <input name="customer_image" class="form-control" type="file" id="image">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">الصورة</label>

                            </div>
                            <!-- end row -->

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img id="showImage" class="rounded avatar-lg" alt="200x200" src="{{asset($customer->customer_image) }}" alt="Card image cap">
                                </div>
                            </div>
                            <!-- end row -->


                            <input type="submit" class="btn btn-info waves-effect waves-light" value="تعديل الزبون">

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
    $(document).ready(function() {
        $('#myForm').validate({
            rules: {
                name: {
                    required: true,
                },
                mobile_no: {
                    required: false,
                },
                email: {
                    required: false,
                },
                address: {
                    required: false,
                },
            },
            messages: {
                name: {
                    required: 'Please Enter Your Name',
                },
                mobile_no: {
                    required: 'Please Enter Your Mobile Number',
                },
                email: {
                    required: 'Please Enter Your Email',
                },
                address: {
                    required: 'Please Enter Your Address',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        })
    })
</script>

@endsection