<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index($id) {
        return view('download', [
            'fileid' => $id
        ]);
    }

    public function download($id) {
        if ($id == '16431595-5175-44CE-A8A1-3F9A416A6BCC') {
            if (Gate::allows('download-pdf')) {
                return response()->download(storage_path('files/The Apostolate\'s Family Catechism, Volume 1.pdf'));
            }

        } else if ($id == '9C3ABD70-56BA-40AB-BF9E-EA78A71977EA') {
            if (Gate::allows('download-pdf')) {
                return response()->download(storage_path('files/The Apostolate\'s Family Catechism, Volume 2.pdf'));
            }
        }

        abort(404);
    }
}
