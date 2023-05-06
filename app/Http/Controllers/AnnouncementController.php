<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Zet de datumtaal in het Nederlands
        setlocale(LC_ALL, 'nld_nld');

        // Haalt alle mededelingen op
        $announcements = Announcement::all();

        // Sorteerd alle mededelingen op aflopende datum
        $announcementsSorted = $announcements->sortBy([
            ['created_at', 'desc'],
        ]);

        // Stuurt de gebruiker naar announcement.index met alle gesorteerde datums
        return view("announcement.index", compact('announcementsSorted'));
    }
}
