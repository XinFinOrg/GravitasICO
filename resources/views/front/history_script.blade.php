<script type="text/javascript">
     function history_page_load(id)
     {
            if(id=='1')
            {
                window.location.href="{{url('deposit_history')}}";
            }
            if(id=='2')
            {
                window.location.href="{{url('transfer_history')}}";
            }
            if(id=='3')
            {
                window.location.href="{{url('exchange_history')}}";
            }
            if(id=='4')
            {
                window.location.href="{{url('trade_history')}}";
            }


     }
 </script>