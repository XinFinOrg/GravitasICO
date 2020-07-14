
@extends('front.layout.front')
@section('content')

<!-- Order book data table -->
    <section class="mt60" style="min-height:740px;">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-default noBorder">

                        <div class="panel-body">
                            <!-- <h4 class="uppercase">Transaction History</h4> -->
                          @include('front.history_top')
                                <br>



                            <div class="table-responsive">
                                <table id="mytable" class="table table-striped table-bordered tableBorder" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction ID</th>
                                            <th>Type</th>
                                            <th>Receive Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($result)
                                    @foreach($result as $val)
                                        <tr>
                                            <td>{{$val->created_at}}</td>
                                            <td>{{$val->transaction_id}}</td>
                                            <td>{{$val->type}}</td>
                                            <td>{{$val->amount}}</td>
                                            <td>{{$val->currency_name}}</td>
                                            <td>{{$val->status}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="row pull-right">
                                      @include('front.pagination', ['paginator' => $result])
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- / Order book data table -->

@endsection

@section('xscript')
@include('front.history_script')
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#mytable').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
         "searching": true
    });
});

    function history_page_load(id)
    {
        if(id=='1')
        {
            window.location.href="<?php echo e(url('deposit_history')); ?>";
        }
        if(id=='2')
        {
            window.location.href="<?php echo e(url('transfer_history')); ?>";
        }
        if(id=='3')
        {
            window.location.href="<?php echo e(url('exchange_history')); ?>";
        }
        if(id=='4')
        {
            window.location.href="<?php echo e(url('trade_history')); ?>";
        }
        if(id=='5')
        {
            window.location.href="<?php echo e(url('swap_history')); ?>";
        }

        if(id=='6')
        {
            window.location.href="<?php echo e(url('ico_history')); ?>";
        }


    }
</script>
@endsection
