<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(['message' => 'Ticket deleted']);
    }

    public function show($id)
    {
        return Ticket::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'    => 'required|min:3|max:255',
            'gender'  => 'required|in:male,female',
            'inquiry' => 'required|string',
            'status'  => 'required|in:new,processing,complete,cancel',
        ]);
        $ticket = Ticket::findOrFail($id);
        $ticket->update($validatedData);

        return response()->json([
            'message' => 'Ticket updated successfully',
            'data'    => $ticket
        ], 200);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'gender'  => 'required|string|max:20',
            'inquiry' => 'required|string|min:3',
            'status'  => 'required|string|max:50',
        ]);
        $ticket = Ticket::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'inquiry' => $request->inquiry,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);
        return response()->json([
            'message' => 'Ticket registered successfully',
            'ticket' => $ticket
        ], 201);
    }
}
