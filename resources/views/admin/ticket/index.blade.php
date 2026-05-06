@extends('admin.layout.app')
@section('title','Ticket Manage')


@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                   
                </div>
                <h4 class="page-title">Ticket Manage</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Ticket ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->ticket_id}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->phone}}</td>
                            <td>{{ $value->ticketdetails()->latest()->first()->message ?? "" }}</td>
                            <td>
                                <div class="button-list">
                                    @if($value->status == 1)
                                        <form method="post" action="{{route('admin.ticket.inactive')}}" class="d-inline"> 
                                        @csrf
                                            <input type="hidden" value="{{$value->id}}" name="hidden_id">       
                                            <button type="submit" class="btn btn-xs  btn-secondary waves-effect waves-light change-confirm"><i style="font-size:14px;" class="fa-solid fa-thumbs-down"></i></button>
                                        </form>
                                    @else
                                        <form method="post" action="{{route('admin.ticket.active')}}" class="d-inline">
                                            @csrf
                                            <input type="hidden" value="{{$value->id}}" name="hidden_id">        
                                            <button type="submit" class="btn btn-xs  btn-success waves-effect waves-light change-confirm"><i style="font-size:14px;" class="fa-solid fa-thumbs-up"></i></button>
                                        </form>
                                    @endif
                                    <a href="{{route('admin.ticket.edit',$value->ticket_id)}}" class="btn btn-xs btn-primary waves-effect waves-light"><i style="font-size:14px;" class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection
