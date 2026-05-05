<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Ticketdetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function ticket_store(Request $request)
    {
        // dd($request->all());
        $ticket = new Ticket();
        $ticket->customer_id = $request->customer_id;
        $ticket->ticket_id = rand(11111, 99999) . '-' . uniqid();
        $ticket->name = $request->name;
        // $ticket->type = $request->type;
        $ticket->email = $request->email;
        $ticket->phone = $request->phone;
        $ticket->save();

        $ticket_details = new Ticketdetails();
        $ticket_details->tkt_id = $ticket->id;
        $ticket_details->ticket_id = $ticket->ticket_id;
        $ticket_details->message = $request->message;
        if ($request->file('image')) {
            $image = $request->file('image');

            $imageName = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/uploads/ticket/';
            $image->move($imagePath, $imageName);

            $ticket_details->image = $imagePath . $imageName;
        }
        $ticket_details->save();

        return response()->json([
            'status' => true,
            'message' => 'Ticket Create Success !',
            'ticket' => $ticket,
            'ticketdetails' => $ticket_details,
        ], 200);
    }

    public function ticket_list()
    {
        $customer_id = Auth::user()->id;

        $tickets = Ticket::where('customer_id', $customer_id)->with('ticketdetails')->get();
        return response()->json([
            'status' => true,
            'message' => 'Ticket List',
            'data' => $tickets,
        ], 200);
    }

    public function ticket_reply_list($ticket_id)
    {
        $ticketreplaydetails = Ticketdetails::where('ticket_id', $ticket_id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Ticket Replay Details List',
            'data' => $ticketreplaydetails,
        ], 200);
    }

    public function ticket_reply_submit(Request $request)
    {
        // dd($request->all());
        $ticket_details = new Ticketdetails();
        $ticket_details->ticket_id = $request->ticket_id;
        $ticket_details->message = $request->message;
        if ($request->file('image')) {
            $image = $request->file('image');

            $imageName = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/uploads/ticket/';
            $image->move($imagePath, $imageName);

            $ticket_details->image = $imagePath . $imageName;
        }
        $ticket_details->save();

        return response()->json([
            'status' => true,
            'message' => 'Ticket Replay Details List',
            'data' => $ticket_details,
        ], 200);
    }

}
