<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Ticketdetails;
use Toastr;

class TicketController extends Controller
{
     public function index(Request $request)
    {
        $show_data = Ticket::orderBy('id','DESC')->with('ticketdetails')->get();
        return view('admin.ticket.index',compact('show_data'));
    }
    
    public function edit($ticket_id)
    {
        $edit_data = Ticket::with('ticketdetails')->where('ticket_id',$ticket_id)->first();
        return view('admin.ticket.edit',compact('edit_data'));
    }
    
    public function ticketdetails_replay(Request $request, $ticketdetails_id)
    {
        $ticket_details            = new Ticketdetails();
        $ticket_details->ticket_id = $request->ticket_id;
        $ticket_details->replay    = $request->replay;
        
         if ($request->file('image')) {
            $image = $request->file('image');

            $imageName          = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath          = 'public/uploads/ticket/';
            $image->move($imagePath, $imageName);

            $ticket_details->replay_image   = $imagePath . $imageName;
        }
        
        $ticket_details->save();
        return back()->with('success','Replay Added!');
    }
    
    public function inactive(Request $request)
    {
        $inactive =Ticket::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active =Ticket::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
}
