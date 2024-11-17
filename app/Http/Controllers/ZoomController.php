<?php

namespace App\Http\Controllers;

use App\Services\ZoomService;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function createMeeting(Request $request)
{
    $meetingData = [
        'topic' => $request->input('topic', 'Sessão de Telemedicina'),
        'type' => 2, 
        'start_time' => $request->input('start_time'),
        'duration' => $request->input('duration', 30),
        'settings' => [
            'host_video' => true,
            'participant_video' => true,
        ],
    ];

    try {
        $meeting = $this->zoomService->createMeeting($meetingData);

        if (isset($meeting['id'])) {
            return view('zoom.create-meeting')->with('meeting', $meeting);
        } else {
            return view('zoom.create-meeting')->with('error', 'Falha ao criar reunião.');
        }
    } catch (\Exception $e) {
        return view('zoom.create-meeting')->with('error', 'Zoom API Error: ' . $e->getMessage());
    }
}

}
