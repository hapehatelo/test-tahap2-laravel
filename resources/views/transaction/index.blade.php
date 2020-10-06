@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Transactions</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sisa Saldo: Rp {{ number_format(($sisa_saldo), 0, '', '.') }}</h3>
                </div>
                <!-- /.card-header -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Add Transaction</button>
                <div class="card-body">
                    <form action="{{ url()->current() }}" method="get">
                    <div class="form-group" style="max-width: 300px" >
                        <label>Rentang Tanggal:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                            </div>
                            <input type="text" name="range_date" class="form-control" id="reservation">
                            <button type="submit" class="btn btn-danger modal-delete">GO</button>
                        </div>
                        <!-- /.input group -->
                    </div>
                    </form>

                        
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Nominal</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $transaction->category->name }}</td>
                            <td>{{ $transaction->category->type }}</td>
                            <td>Rp {{ number_format($transaction->nominal, 0, '', '.') }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>{{ date('d-m-Y', strtotime($transaction->date)) }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#modal-edit" data-item="{{ json_encode($transaction) }}" type="button" class="btn btn-success btn-xs modal-edit"><i class="fas fa-pencil-alt"></i></button>
                                <button data-toggle="modal" data-target="#modal-delete" data-item="{{ $transaction->id }}" type="button" class="btn btn-danger btn-xs modal-delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Nominal</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
            </div>
        </div>
    </div>


    <!-- modal add -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" action="{{ url()->current() }}" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Type:</label>
                                <div class="form-check">
                                  <input id="check-pem" class="form-check-input" type="radio" name="type" value="Pemasukan" checked="">
                                  <label class="form-check-label">Pemasukan</label>
                                </div>
                                <div class="form-check">
                                  <input id="check-peng" class="form-check-input" type="radio" name="type" value="Pengeluaran">
                                  <label class="form-check-label">Pengeluaran</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select id="option-category" name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    @if ($category->type === "Pemasukan")
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                          </div>
                        <div class="form-group">
                            <label for="name">Nominal</label>
                            <input type="number" class="form-control" name="nominal" placeholder="Nominal" value="{{old('nominal')}}" required>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
          
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" name="date" class="form-control float-right" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" name="description" placeholder="Description" value="{{old('description')}}" required>  
                            @csrf                     
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- modal edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit" role="form" action="#" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Type:</label>
                                <div class="form-check">
                                <input id="check-pem-edit" class="form-check-input" type="radio" name="type" value="Pemasukan">
                                <label class="form-check-label">Pemasukan</label>
                                </div>
                                <div class="form-check">
                                <input id="check-peng-edit" class="form-check-input" type="radio" name="type" value="Pengeluaran">
                                <label class="form-check-label">Pengeluaran</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select id="option-category-edit" name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    @if ($category->type === "Pemasukan")
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nominal</label>
                            <input type="number" class="form-control modal-input-nominal" name="nominal" placeholder="Nominal" required>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
        
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="date" class="form-control float-right" id="datepicker-edit">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control modal-input-description" name="description" placeholder="Description" required>  
                            @csrf            
                            @method('PUT')            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete transaction?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <form id="form-delete" role="form" action="#" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-light">Yes</button>
                </form>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop
@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">
@endsection
@section('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });


      $('#reservation').daterangepicker();
      


      var datacategory = {!! json_encode($categories) !!};
      $('#check-pem').click(function() {
        if($('#check-pem').is(':checked')) { 
            var dataradio = '';
            datacategory.forEach(val => {
                if (val.type === 'Pemasukan') {
                    dataradio += '<option value="'+val.id+'">'+val.name+'</option>'
                }
            });
            $('#option-category').html(dataradio);
        }
      });

      $('#check-peng').click(function() {
        if($('#check-peng').is(':checked')) { 
            var dataradio = '';
            datacategory.forEach(val => {
                if (val.type === 'Pengeluaran') {
                    dataradio += '<option value="'+val.id+'">'+val.name+'</option>'
                }
            });
            $('#option-category').html(dataradio);
        }
      });


        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        }).datepicker("setDate", new Date());



        $('.modal-edit').click(function(){
            var data = JSON.parse($(this).attr('data-item'));

            var datacategoryedit = {!! json_encode($categories) !!};

            $('#check-pem-edit').click(function() {
                if($('#check-pem-edit').is(':checked')) { 
                    var dataradioedit = '';
                    datacategoryedit.forEach(val => {
                        if (val.type === 'Pemasukan') {
                            dataradioedit += '<option value="'+val.id+'">'+val.name+'</option>'
                        }
                    });
                    $('#option-category-edit').html(dataradioedit);
                }
            });

            $('#check-peng-edit').click(function() {
                if($('#check-peng-edit').is(':checked')) { 
                    var dataradioedit = '';
                    datacategoryedit.forEach(val => {
                        if (val.type === 'Pengeluaran') {
                            dataradioedit += '<option value="'+val.id+'">'+val.name+'</option>'
                        }
                    });
                    $('#option-category-edit').html(dataradioedit);
                }
            });



            if (data.category.type === 'Pemasukan') {
                $("#check-pem-edit").prop("checked", true);

                var dataradioedit = '';
                datacategoryedit.forEach(val => {
                    if (val.type === 'Pemasukan') {
                        if (val.name === data.category.name) {
                            dataradioedit += '<option value="'+val.id+'" selected>'+val.name+'</option>';
                        } else {
                            dataradioedit += '<option value="'+val.id+'">'+val.name+'</option>';
                        }
                    }
                });
                $('#option-category-edit').html(dataradioedit);
            } else if(data.category.type === 'Pengeluaran') {
                $("#check-peng-edit").prop("checked", true);

                var dataradioedit = '';
                datacategoryedit.forEach(val => {
                    if (val.type === 'Pengeluaran') {
                        if (val.name === data.category.name) {
                            dataradioedit += '<option value="'+val.id+'" selected>'+val.name+'</option>';
                        } else {
                            dataradioedit += '<option value="'+val.id+'">'+val.name+'</option>';
                        }
                    }
                });
                $('#option-category-edit').html(dataradioedit);
            }


            $('.modal-input-nominal').val(data.nominal);
            $('.modal-input-description').val(data.description);
            //Date picker
            $('#datepicker-edit').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
            }).datepicker("setDate", new Date(data.date));

            

            $('#form-edit').attr('action', '/transaction/'+data.id);
        });


        


        $('.modal-delete').click(function(){
            var data = $(this).attr('data-item');
            $('#form-delete').attr('action', '/transaction/'+data);
        });
    });
</script>
<script>

</script>
@stop