<!DOCTYPE html>
<html>
<meta>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="id=edge">
    <title>Infini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</head>
<body>
    <section style="padding-top: 60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Customers <a href="#" data-toggle="modal" data-target="#customerModal">Add New Customer</a>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr id="cid{{ $customer->id }}">
                                        <td>{{ $customer->first_name }}</td>
                                        <td>{{ $customer->last_name }}</td>
                                        <td>{{ $customer->mobile }}</td>
                                        <td>{{ $customer->email_address }}</td>
                                        <td>
                                            @php $selStatus = \Illuminate\Support\Facades\DB::table('status')->select(['name'])->where('flag', 1)->where('id', '=', $customer->status)->get(); @endphp
                                            {{ $selStatus[0]->name }}
                                        </td>
                                        <td>
                                            @php $selSource = \Illuminate\Support\Facades\DB::table('source')->select(['name'])->where('flag', 1)->where('id', '=', $customer->source)->get(); @endphp
                                            {{ $selSource[0]->name }}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="getCustomer({{$customer->id}})" data-toggle="modal">Edit</a> |
                                            <a href="javascript:void(0)" onclick="deleteCustomer({{$customer->id}})">Delete</a>
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
    </section>

    <!-- Creating New Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="customerForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_address">Email</label>
                                    <input type="text" class="form-control" id="email_address" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status">
                                        <option value="">---Select Status---</option>
                                        @foreach($status as $sts)
                                            <option value="{{$sts->id}}">{{$sts->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="source">Source</label>
                                    <select class="form-control" id="source">
                                        <option value="">---Select Source---</option>
                                        @foreach($source as $src)
                                            <option value="{{$src->id}}">{{$src->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Editing Customer -->
    <div class="modal fade" id="customerEditModal" tabindex="-1" aria-labelledby="customerEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="customerEditForm">
                        @csrf
                        <input type="hidden" id="id" name="id" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="first_name_edit">First Name</label>
                                    <input type="text" class="form-control" id="first_name_edit" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="last_name_edit">Last Name</label>
                                    <input type="text" class="form-control" id="last_name_edit" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_address_edit">Email</label>
                                    <input type="text" class="form-control" id="email_address_edit" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mobile_edit">Mobile</label>
                                    <input type="text" class="form-control" id="mobile_edit" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_edit">Status</label>
                                    <select class="form-control" id="status_edit">
                                        <option value="">---Select Status---</option>
                                        @foreach($status as $sts)
                                            <option value="{{$sts->id}}">{{$sts->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="source_edit">Source</label>
                                    <select class="form-control" id="source_edit">
                                        <option value="">---Select Source---</option>
                                        @foreach($source as $src)
                                            <option value="{{$src->id}}">{{$src->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#customerForm").submit(function(ev) {
            ev.preventDefault();
            let first_name = $("#first_name").val();
            let last_name = $("#last_name").val();
            let mobile = $("#mobile").val();
            let email_address = $("#email_address").val();
            let status = $("#status").val();
            let source = $("#source").val();
            let _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{ route('customer.add') }}",
                type: "post",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    mobile: mobile,
                    email_address: email_address,
                    status: status,
                    source: source,
                    _token: _token
                },
                success: function(resp) {
                    if (resp) {
                        console.log(resp);
                        $("#customerTable tbody").append('<tr><td>'+resp[0].first_name+'</td><td>'+resp[0].last_name+'</td><td>'+resp[0].mobile+'</td><td>'+resp[0].email_address+'</td><td>'+resp[0].stsname+'</td><td>'+resp[0].srcname+'</td><td><a href="javascript:void(0)" onclick="getCustomer('+ +resp[0].id +')" data-toggle="modal">Edit</a></td></tr>');
                        $("#customerForm")[0].reset();
                        $("#customerModal").modal('hide');
                    }
                }
            });
        });

        $("#customerEditForm").submit(function(ev) {
            ev.preventDefault();
            let id = $("#id").val();
            let first_name = $("#first_name_edit").val();
            let last_name = $("#last_name_edit").val();
            let mobile = $("#mobile_edit").val();
            let email_address = $("#email_address_edit").val();
            let status = $("#status_edit").val();
            let source = $("#source_edit").val();
            let _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{ route('customer.update') }}",
                type: "post",
                data: {
                    id: id,
                    first_name: first_name,
                    last_name: last_name,
                    mobile: mobile,
                    email_address: email_address,
                    status: status,
                    source: source,
                    _token: _token
                },
                success: function(resp) {
                    if (resp) {
                        $('#cid' + resp[0].id + ' td:nth-child(1)').text(resp[0].first_name);
                        $('#cid' + resp[0].id + ' td:nth-child(2)').text(resp[0].last_name);
                        $('#cid' + resp[0].id + ' td:nth-child(3)').text(resp[0].mobile);
                        $('#cid' + resp[0].id + ' td:nth-child(4)').text(resp[0].email_address);
                        $('#cid' + resp[0].id + ' td:nth-child(5)').text(resp[0].stsname);
                        $('#cid' + resp[0].id + ' td:nth-child(6)').text(resp[0].srcname);
                        $("#customerEditModal").modal('toggle');
                        $("#customerEditForm")[0].reset();
                    }
                }
            });
        })

        function getCustomer(id) {
            $.get(`customers/${id}`, function(resp) {
                $("#id").val(resp.id);
                $("#first_name_edit").val(resp.first_name);
                $("#last_name_edit").val(resp.last_name);
                $("#email_address_edit").val(resp.email_address);
                $("#mobile_edit").val(resp.mobile);
                $("#source_edit").val(resp.source);
                $("#status_edit").val(resp.status);
                $("#customerEditModal").modal("toggle");
            })
        }

        function deleteCustomer(id) {
            if(confirm("Are you sure?")) {
                $.ajax({
                    url: `customers/${id}`,
                    type: 'delete',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(resp) {
                        $(`#cid${id}`).remove();
                        alert(resp.success);
                    }
                })
            }
        }
    </script>
</body>
</html>


