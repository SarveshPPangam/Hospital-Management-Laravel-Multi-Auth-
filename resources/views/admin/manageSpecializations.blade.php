@extends('layouts.admin')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                    <form method = "POST" id="addSpecialization" class=" text-center m-2">
                        @csrf
                        <label>Add specialization</label>
                        <input class="form-specialization" type="text" name="Specialization" required>
                        <input class="btn btn-outline-dark" type="submit" name="add" value="Add" id="add">
                    </form>
                    <table class="table" id="spec_table">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Created at </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    <tbody id="table_data">
                    @if ($specializations->count())

                        @foreach ($specializations as $specialization)

                            <tr id="sid{{ $specialization->id }}">
                                <td> {{ $specialization->id }} </td>
                                <td> {{ $specialization->name }} </td>
                                <td> {{ $specialization->created_at }} </td>
                                <td> <a href="javascript:void(0)" class="btn btn-info" onclick="editSpecialization({{ $specialization->id }})"> Edit  </a> </td>
                                <td> <a href="javascript:void(0)" onclick="deleteSpecialization({{ $specialization->id }})" class="btn btn-danger"> Delete  </a> </td>
                            </tr>
                        @endforeach


                    @else
                        <Strong>There are no specializations!</Strong>
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
       


  <!-- Modal -->
  <div class="modal fade" id="specializationEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="specializationEditForm">
              @csrf
              <div class="form-group">
                  <label for="specializationName"> Name </label>
                  <input type="hidden" id="specializationID" name="specializationID">
                  <input type="text" class="form-control" id="specializationName"/>
              </div>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>






{{-- Add specialization script --}}
<script>
$(document).ready(function(){

 $('#addSpecialization').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"{{ url('admin/addSpecialization') }}",
   method:"POST",
   data:$(this).serialize(),
   dataType:"html",
   beforeSend:function(){
    $('#add').attr('disabled', 'disabled');
   },
   success:function(data){
    $('#add').attr('disabled', false);

    var response = JSON.parse(data);
    console.log(response.name);
    if(response.name)
    {
     var html = '<tr id="'+"sid".concat(response.id)+'">';
    html += '<td>'+response.id+'</td>';
    html += '<td>'+response.name+'</td>';
    html += '<td>'+response.created_at.substring(0,19).replace("T", " ")+'</td>';
    html += '<td> <a href="javascript:void(0)" class="btn btn-info" onclick="editSpecialization('+response.id+')"> Edit  </a> </td>'
    html += '<td> <a href="javascript:void(0)" onclick="deleteSpecialization('+response.id+')" class="btn btn-danger"> Delete  </a> </td></tr>';

     $('#table_data').prepend(html);
     $('#addSpecialization')[0].reset();

    }
   }
  })
 });

});
</script>

{{-- Edit specialization script --}}
<script>
    function editSpecialization(id)
    {
        $.get('/admin/getSpecialization/'+id, function(specialization){
            $('#specializationID').val(specialization.id);
            $('#specializationName').val(specialization.name);
            $('#specializationEditModal').modal('toggle');
        });
    }

    $("#specializationEditForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"{{ route('updateSpecialization') }}",
            type:"PUT",
            data:{
                id:$("#specializationID").val(),
                name:$("#specializationName").val(),
                _token: '{!! csrf_token() !!}',
            },
            success:function(response){
                $('#sid'+ response.id +' td:nth-child(1)').text(response.id);
                $('#sid'+ response.id +' td:nth-child(2)').text(response.name);
                $("#specializationEditModal").modal('toggle');
                $("#specializationEditForm")[0].reset();
            }
        });
    });
</script>




{{-- Delete specialization script --}}
<script>
    function deleteSpecialization(id)
    {
        if(confirm("Are you sure you want to delete the specialization?"))
        {
            $.ajax({
                url: '/admin/deleteSpecialization/'+id,
                type: 'DELETE',
                data:{
                    _token: '{!! csrf_token() !!}',
                },
                success:function(response)
                {
                    //console.log("in success");
                    $('#sid'+id).remove();
                },
                error:function(err)
                {
                    console.log(err);
                }
            })
        }
    }
</script>
@endsection
