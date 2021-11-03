@extends('layouts.app')
@section('content')
{{--  @include('partials.nav')  --}}
    <link href="{{ asset('application/public/css/daterangepicker.css')}}" rel="stylesheet">
    <div class="row">
   @include('partials.sidebar')
   <div class="col-md-9 " style="padding-right: 0">
      @include('partials.flash')
  
      <div class="" id="firstload">
        <div class="col-md-12">
           <div class="card mb-0">
              <div class="header">
                 <h4>Create Transactional Report</h4>

              </div>
              <div class="body">
               <div class='input-group date'>
                <form action="{{route('create.reports')}}" method="post">
              {{csrf_field()}}
                <label class="form-label" for="daterange">Date range of the report to be generated</label>
                <input type="text" id="daterange" class="form-control" name="daterange" value="" />
                
                <input type="submit" name="submit" class="btn btn-info">
              </form>
              </div>
              </div>
           </div>
        </div>
      </div>
     
   </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="{{ asset('application/public/js/daterangepicker.js')}}"></script>
    <script>
      $(function() {
        var endDate = new Date();//today

        var currMonth = endDate.getMonth();
        var currYear = endDate.getFullYear();
        var startDate = new Date(currYear, currMonth, 1);

        $('input[name="daterange"]').daterangepicker({
       "showDropdowns": true,
          ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          "startDate": startDate,
          "endDate": endDate
      }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
      });
      </script>

@endsection
@section('footer')
@include('partials.footer')
@endsection