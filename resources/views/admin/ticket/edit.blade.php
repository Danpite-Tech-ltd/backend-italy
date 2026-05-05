@extends('admin.layout.app')
@section('title','Ticket')

<style>
.chat-input-wrapper {
    background: #f8f9fa;
}

.upload-icon {
    cursor: pointer;
    font-size: 18px;
    color: #6c757d;
}

.upload-icon:hover {
    color: #198754;
}
</style>

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <!-- <div class="page-title-right">
                    <a href="{{route('admin.ticket.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Ticket</h4> -->
            </div>
        </div>
    </div>
    <!-- end page title -->
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        
                            <tbody>
                                <tr>
                                    <th colspan="2" class="text-center">Ticket Information</th>
                                </tr>
                                <tr>
                                    <th>Ticket ID</td>
                                    <td>{{$edit_data->ticket_id}}</td>
                                </tr>
                                <tr>
                                    <th>Name</td>
                                    <td>{{$edit_data->name}}</td>
                                </tr>
                                <tr>
                                    <th>Email</td>
                                    <td>{{$edit_data->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</td>
                                    <td>{{$edit_data->phone}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-12">
                        <table id="datatable-buttons"
                            class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr style="background: #DCE3EC">
                                    <th class="d-flex justify-content-between">
                                        <span>Customer Message</span>
                                        <span>Replay</span>
                                    </th>
                                </tr>
                            </thead>


                            <tbody>

                                <tr>
                                    <td>
                                        @if(session('success'))
                                            <div class="alert alert-success">{{session('success')}}</div>
                                        @endif
                                        @foreach(App\Models\Ticketdetails::where('ticket_id', $edit_data->ticket_id)->get() as $value)
                                            
                                            @if($value->message)
                                                <br>
                                                <span>{{$value->message}}</span>
                                            @endif
                                            
                                            @if($value->image)
                                                <img 
                                                    src="{{ asset($value->image) }}" 
                                                    style="width:250px;height:250px;"
                                                    class="my-1 d-flex justify-content-end img-thumbnail preview-image"
                                                    style="cursor:pointer"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#imageModal"
                                                    onclick="showImage('{{ asset($value->image) }}')"
                                                >
                                            @endif
                                            
                                            
                                            
                                            @if($value->replay)
                                                <span class="d-flex justify-content-end">{{$value->replay}}</span>
                                            @endif
                                            @if($value->replay_image)
                                                <div class="d-flex justify-content-end">
                                                    <img src="{{ asset($value->replay_image) }}" 
                                                        style="width:250px;height:250px;"
                                                         class="rounded shadow-sm">
                                                </div>
                                            @endif
                                        @endforeach
                                        <form action="{{ route('admin.ticket.replay',$edit_data->ticket_id) }}" 
                                              method="POST"
                                              enctype="multipart/form-data"
                                              class="mt-3">
                                        
                                            @csrf
                                        
                                            <input type="hidden" name="ticket_id" value="{{ $edit_data->ticket_id }}">
                                        
                                            <div class="chat-input-wrapper d-flex align-items-center p-2 border rounded">
                                        
                                                <!-- Image Upload Button -->
                                                <label for="imageUpload" class="me-2 mb-0 upload-icon">
                                                    <i class="fa fa-image"></i>
                                                </label>
                                                <input type="file" name="image" id="imageUpload" hidden accept="image/*">
                                        
                                                <!-- Textarea -->
                                                <textarea class="form-control border-0 shadow-none"
                                                          name="replay"
                                                          placeholder="Type your message..."
                                                          rows="3"></textarea>
                                        
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-success ms-2 rounded-circle">
                                                    <i class="fa fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        
                                            <!-- Image Preview -->
                                            <div id="previewContainer" class="mt-2 d-none">
                                                <img id="imagePreview" style="width:80px;height:80px;" class="rounded shadow-sm">
                                                <span class="text-danger ms-2" style="cursor:pointer" onclick="removeImage()">Remove</span>
                                            </div>
                                        
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>


<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });
</script>

<script>
    function showImage(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
    }
</script>

<script>
document.getElementById('imageUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview').src = event.target.result;
            document.getElementById('previewContainer').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});

function removeImage() {
    document.getElementById('imageUpload').value = "";
    document.getElementById('previewContainer').classList.add('d-none');
}
</script>
@endsection
