<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function purchaseTicket(Request $request)
    {
        if (Auth::check()) {
            $userId = auth()->user()->id;
        } else {
            return response()->json(['error' => 'The user is not logged in.'], 401);
        }

        $drawId = $request->input('draw_id');

        if(!$drawId) {
            throw new \InvalidArgumentException('No draw id provided.');
        }

        $response = $this->ticketService->purchaseTicket($userId, $drawId);

        return response()->json($response);
    }
}
