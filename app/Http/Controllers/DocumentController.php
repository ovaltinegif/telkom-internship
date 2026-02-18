<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DocumentController extends Controller
{
    // Upload Extension Letter (Surat Perpanjangan)
    public function storeExtension(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Check if extension already exists
        $existingExtension = Document::where('internship_id', $internship->id)
            ->where('type', 'perpanjangan_magang')
            ->exists();

        if ($existingExtension) {
            return back()->with('error', 'Anda sudah mengajukan perpanjangan magang. Pengajuan hanya dapat dilakukan satu kali.');
        }

        $path = $request->file('file')->store('extensions', 'public');

        Document::create([
            'internship_id' => $internship->id,
            'name' => 'Surat Perpanjangan Magang', 
            'type' => 'perpanjangan_magang',
            'file_path' => $path,
            'is_verified' => false,
        ]);

        return back()->with('success', 'Surat perpanjangan magang berhasil diunggah.');
    }

    // Upload Final Report (Laporan Akhir)
    public function storeFinalReport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:20480', // 20MB limit
        ]);

        $internship = Internship::where('student_id', Auth::id())->first();
        
        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Check if current date >= end_date
        /*
        // Removing explicit check to allow early upload if needed, or re-enable based on strict requirement
        if (Carbon::now()->lt(Carbon::parse($internship->end_date))) {
             return back()->with('error', 'Laporan magang hanya dapat diunggah setelah tanggal selesai magang.');
        }
        */
        // Re-enabling based on user requirement: "laporan magang ketika tanggalnya selesai"
        if (Carbon::now()->lt(Carbon::parse($internship->end_date))) {
             return back()->with('error', 'Laporan magang hanya dapat diunggah setelah tanggal selesai magang (' . $internship->end_date . ').');
        }

        $path = $request->file('file')->store('reports', 'public');

        Document::create([
            'internship_id' => $internship->id,
            'name' => 'Laporan Akhir Magang',
            'type' => 'laporan_akhir',
            'file_path' => $path,
            'is_verified' => false,
        ]);

        return back()->with('success', 'Laporan akhir berhasil diunggah.');
    }
    // Upload Signed Pakta Integritas (Onboarding)
    public function storePaktaIntegritas(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        if ($internship->status !== 'onboarding') {
            return back()->with('error', 'Status magang tidak valid untuk mengunggah Pakta Integritas.');
        }

        $path = $request->file('file')->store('documents/student/pakta', 'public');

        Document::create([
            'internship_id' => $internship->id,
            'name' => 'Pakta Integritas (Signed)',
            'type' => 'pakta_integritas_signed',
            'file_path' => $path,
            'is_verified' => false,
        ]);

        return back()->with('success', 'Pakta Integritas berhasil diunggah. Menunggu verifikasi Admin.');
    }
}
