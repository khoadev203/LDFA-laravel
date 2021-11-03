@extends('layouts.app')
@section('content')
{{--  @include('partials.nav')  --}}
<div class="row">
   @include('partials.sidebar')
   <div class="col-md-9 " style="padding-right: 0">
      @include('partials.flash')
      <div class="accordionButton row mx-0 mb-3 on"><a class="col-12 bg-primary text-white py-2 d-block font-weight-600 rounded" href="javascript:;">Enter details for a button!</a></div>
      <div class="" id="firstload">
        <div class="col-md-12">
           <div class="card mb-0">
              <div class="header">
                 <h2>{{__('Create a ')}}<strong>{{$type}}</strong> {{ __(' Button')}}</h2>
              </div>
              <div class="body">
             
                 <form class="d-flex justify-content-left" enctype="multipart/form-data"  method="post" action="{{route('button.createbutton', $type)}}" id="withdrawal_form">
                    {{csrf_field()}}
                     <div class="row mb-5 w-100">

                        @if($type == 'Buy')
                        <div class="col-lg-6">
                           <div class="form-group ">
                              <label for="message">{{__('Item name')}}</label>
                              <input type="text" name="itemname"  value="" class="form-control" required>
                           </div>
                        </div>
                        <div class="col-lg-6" id="quantity_div">
                           <div class="form-group ">
                              <label for="message">{{__('Quantity')}}</label>
                              <input type="number" name="quantity"  value=""  class="form-control" id="quantity"required>
                           </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="message">{{__('Price')}}</label><br>
                              <input type="number" name="price" class="form-control w-75 mr-2 d-inline" value="0">{{__('Ounce')}}
                           </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="form-group ">
                              <label for="message">{{__('Shipping')}}</label><br>
                              <input type="number" name="shipping" class="form-control d-inline w-75 mr-2" value="0" step="0.01" required>{{__('Ounce')}}
                           </div>
                        </div>

                        <div class="col-lg-12">
                           <div class="border p-3 mt-3">
                              <div class="form-check">
                                 <input type="checkbox" name="add_dropdown" id="add_dropdown" class="form-check-input">
                                 <label class="form-check-label" for="add_dropdown">Add drop-down menu</label>
                              </div>

                              <div id="custom_dropdown_container">                                 
                              </div>

                              <div id="add-another-dropdown-container" class="d-none">
                                 <a href="javascript:void();" id="btn-add-another-dropdown">Add another drop-down menu</a>
                              </div>

                              <div class="d-none" id="custom_dropdown_editor">
                                 <div class="form-group">
                                    <label class="form-label">Name of drop-down menu(ex: "Colors", "Sizes")</label><br>
                                    <input type="text" id="dropdown-name" class="mb-3"><br>
                                    <label class="form-label">Menu option name</label><br>
                                    <input type="text" name="dropdown-option-1" class="mb-3" value="Option 1"><br>
                                    <input type="text" name="dropdown-option-2" class="mb-3" value="Option 2"><br>
                                    <input type="text" name="dropdown-option-3" class="mb-3" value="Option 3"><br>
                                 </div>
                                 <button class="btn btn-link" id="btn-add-dropdown-option"> + Add another option</button><br>
                                 <button class="btn btn-warning btn-sm mr-2" id="btn-add-dropdown-item">Done</button><button class="btn btn-light btn-sm" id="btn-cancel-dropdown-edit">Cancel</button>
                              </div>
                           </div>
                        </div>
                        @elseif($type=="Subscribe")
                        <div class="col-lg-6">
                           <div class="form-group ">
                              <label for="message">{{__('Item name')}}</label>
                              <input type="text" name="itemname"  value="" class="form-control" required>
                           </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="message">{{__('Billing amount each cycle')}}</label><br>
                              <input type="number" name="price" class="form-control w-75 mr-2 d-inline" value="0">{{__('Ounce')}}
                           </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="form-group row mx-0">
                              <label class="col-12 pl-0" for="billing_cycle">{{__('Billing cycle')}}</label>
                              <select class="col-auto pl-0" name="billing_cycle" value="" >
                                 @for($i =1; $i <= 30 ; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <select class="col-4 pl-0" name="billing_cycle_unit" value="" >
                                 <option value="day">day(s)</option>
                                 <option value="week">week(s)</option>
                                 <option value="month">month(s)</option>
                                 <option value="year">year(s)</option>
                              </select>
                           </div>
                        </div>
                       
                        <div class="col-lg-6 my-2">
                           <div class="form-group">
                              <label class="col-12 pl-0" for="billing_stop">{{__('After how many cycles should billing stop?')}}</label>
                              <select class="col-4 pl-0" name="billing_stop" value="" >
                                 <option value="0">never</option>
                                 @for($i =1; $i <= 30 ; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                           </div>
                        </div>

                        <div class="col-lg-12">
                           <div class="border p-3 mt-3">
                              <div class="form-check">
                                 <input type="checkbox" name="add_dropdown" id="add_dropdown" class="form-check-input">
                                 <label class="form-check-label" for="add_dropdown">Add a drop-down menu</label>
                              </div>

                              <div id="custom_dropdown_container">                                 
                              </div>

                              <div id="add-another-dropdown-container" class="d-none">
                                 <a href="javascript:void();" id="btn-add-another-dropdown">Add another drop-down menu</a>
                              </div>

                              <div class="d-none" id="custom_dropdown_editor">
                                 <div class="form-group">
                                    <label class="form-label">Name of drop-down menu(ex: "Colors", "Sizes")</label><br>
                                    <input type="text" id="dropdown-name" class="mb-3"><br>
                                    <label class="form-label">Menu option name</label><br>
                                    <input type="text" name="dropdown-option-1" class="mb-3" value="Option 1"><br>
                                    <input type="text" name="dropdown-option-2" class="mb-3" value="Option 2"><br>
                                    <input type="text" name="dropdown-option-3" class="mb-3" value="Option 3"><br>
                                 </div>
                                 <button class="btn btn-link" id="btn-add-dropdown-option"> + Add another option</button><br>
                                 <button class="btn btn-warning btn-sm mr-2" id="btn-add-dropdown-item">Done</button><button class="btn btn-light btn-sm" id="btn-cancel-dropdown-edit">Cancel</button>
                              </div>
                           </div>
                        </div>

                        @else
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="message">{{__('Price')}}</label><br>
                              <input type="number" name="price" class="form-control w-75 mr-2 d-inline" value="">{{__('Ounce')}}
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="message">{{__('Your purpose(optional)')}}</label>
                              <input type="text" name="description" class="form-control mr-2 d-inline">
                           </div>
                        </div>
                        @endif

                        <div class="col-lg-12">
                           <input class="btn btn-primary btn-round waves-effect" value="{{__('Add')}}" type="submit">
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
     
   </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
   $(document).ready( function() {
      var is_adding_new_dropdown = true;
      var editing_index = -1;

      $("#add_dropdown").change( function() {

         is_adding_new_dropdown = true;

         if( $(this).is(':checked')) {
            $('#custom_dropdown_editor').removeClass('d-none');
         } else {
            $('#custom_dropdown_editor').addClass('d-none');
            $('#add-another-dropdown-container').addClass('d-none');
            $('#custom_dropdown_container').empty();
         }
      });

      var original_dropdown = $('#custom_dropdown_editor .form-group').html();
      $('#btn-add-dropdown-option').click(function(e) {
         e.preventDefault();
         var count_inputs = $('#custom_dropdown_editor .form-group input').length;
         $('#custom_dropdown_editor .form-group').append('<input type="text" class="mb-3" name="dropdown-option-' + count_inputs + '" value="Option ' + count_inputs + '"><br>')
      });

      $('#btn-add-dropdown-item').click(function(e) {
         e.preventDefault();
         if($('#dropdown-name').val() == '') {
            alert('Name of drop-down menu is required!');
            return;
         }
         var count_items = $('#custom_dropdown_container .item').length;
         var new_item_index = count_items + 1;

         var dropdown_name = $('#dropdown-name').val();
         var option_names = [];
         $('#custom_dropdown_editor .form-group input').each(function(index) {
            if(index != 0 && $(this).val() != '')
            {
               option_names.push( $(this).val());
            }
         });

         if(is_adding_new_dropdown) {
            $('#custom_dropdown_container').append(
               '<div class="mb-3 item">' +
                  '<input class="form-control-plaintext" name="dropdown-item[' + new_item_index + ']" id="dropdown-item-' + new_item_index + '" value="' + dropdown_name + ': ' + option_names.join(', ') + '" readonly>' +
                  '<button class="btn-edit-dropdown-item btn-light mr-2" item="' + new_item_index + '">Edit</button>' +
                  '<button class="btn-delete-dropdown-item btn-light mr-2" item="' + new_item_index + '">Delete</button>' +
               '</div>'
            );
         } else {
            $('#dropdown-item-' + editing_index).val(dropdown_name + ': ' + option_names.join(', '));
         }
         

         $('#custom_dropdown_editor .form-group').html(original_dropdown);
         $('#custom_dropdown_editor').addClass('d-none');

         if(countItems() > 0) {
            $('#add-another-dropdown-container').removeClass('d-none');
         } else {
            $('#add-another-dropdown-container').addClass('d-none');
         }
      });

      $('#btn-add-another-dropdown').click(function(e) {
         is_adding_new_dropdown = true;
         e.preventDefault();
         $('#custom_dropdown_editor').removeClass('d-none');
      });

      $('#custom_dropdown_container').on('click', '.btn-edit-dropdown-item', function(e) {
         e.preventDefault();
         is_adding_new_dropdown = false;
         var index = $(this).attr('item');
         editing_index = index;
         var str_item = $('#dropdown-item-' + index).val();
         var arr_dropdown = str_item.split(": ");
         var dropdown_name = arr_dropdown[0];
         var arr_options = arr_dropdown[1].split(", ");
         PopulateItemEditForm(dropdown_name, arr_options);
      });

      $('#custom_dropdown_container').on('click', '.btn-delete-dropdown-item', function(e) {
         e.preventDefault();
         $(this).parent().remove();

         if(countItems() > 0) {
            $('#add-another-dropdown-container').removeClass('d-none');
         } else {
            $('#add-another-dropdown-container').addClass('d-none');
            $('#add_dropdown').prop('checked', false); // Unchecks it
         }
      });

      $('#btn-cancel-dropdown-edit').click(function(e) {
         e.preventDefault();
         $('#custom_dropdown_editor').addClass('d-none');
         if(countItems() > 0) {
            $('#add-another-dropdown-container').removeClass('d-none');
         } else {
            $('#add-another-dropdown-container').addClass('d-none');
            $('#add_dropdown').prop('checked', false); // Unchecks it
         }
      })

      function countItems()
      {
         return $('#custom_dropdown_container .item').length;
      }

      function PopulateItemEditForm(dropdown_name, arr_options)
      {
         var container = $('#custom_dropdown_editor .form-group');
         container.empty();
         container.append('<label class=\"form-label\">Name of drop-down menu(ex: \"Colors\", \"Sizes\")</label><br><input type=\"text\" id=\"dropdown-name\" class=\"mb-3\" value="' + dropdown_name + '"><br><label class=\"form-label\">Menu option name</label><br>');
         console.log(arr_options)
         for (var i = 0; i <= arr_options.length - 1; i++) {
            console.log("<input type=\'text\' name=\'dropdown-option-" + (i + 1) + "\' value=\'" + arr_options[i] + "\' class=\'mb-3\'");

            container.append("<input type=\'text\' name=\'dropdown-option-" + (i + 1) + "\' value=\'" + arr_options[i] + "\' class=\'mb-3\'><br>");
         }

         $('#custom_dropdown_editor').removeClass('d-none');
         $('#add-another-dropdown-container').addClass('d-none');
      }
   })
</script>
@endsection

@section('footer')
@include('partials.footer')
@endsection