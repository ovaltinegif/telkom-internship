<?php

namespace App\Http\Controllers;

use App\Models\DailyLogbook;
use App\Models\Internship;
use App\Http\Requests\StoreLogbookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Attendance;

class LogbookController extends Controller
{
    /**
     * Menampilkan daftar semua logbook (Activity).
     */
    public function index()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard');
        }

        $logbooks = DailyLogbook::where('internship_id', $internship->id)
            ->latest()
            ->paginate(10); // Pagination for activity page

        // Fetch Permission History
        $permissions = Attendance::where('internship_id', $internship->id)
            ->where('status', 'permit')
            ->latest()
            ->get();

        // Fetch Attendance History (Present)
        $attendances = Attendance::where('internship_id', $internship->id)
            ->where('status', 'present')
            ->latest()
            ->get();

        return view('logbooks.index', compact('logbooks', 'permissions', 'attendances'));
    }

    /**
     * Menampilkan form isi logbook.
     */
    public function create()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->route('dashboard')->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi logbook.');
        }

        if ($internship->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar dalam program magang atau akun magang Anda belum aktif.');
        }

        // Cek apakah sudah isi logbook HARI INI (Logic Reset 7 Pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();
        $todayLogbook = DailyLogbook::where('internship_id', $internship->id)
            ->whereDate('date', $dateCheck)
            ->exists();

        if ($todayLogbook) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah mengisi logbook hari ini. Logbook hanya dapat diisi satu kali per hari.');
        }

        return view('logbooks.create');
    }

    /**
     * Menyimpan data logbook ke database.
     */
    public function store(StoreLogbookRequest $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi logbook.');
        }

        if ($internship->status !== 'active') {
            return back()->with('error', 'Data magang aktif tidak ditemukan. Hubungi admin.');
        }

        // 3. Handle Upload File Bukti (Jika ada)
        // Check duplicate date (Logic Reset 7 Pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();

        // Use provided date if it exists, otherwise use dateCheck (7 AM logic)
        $targetDate = $request->date ?? $dateCheck;

        $exists = DailyLogbook::where('internship_id', $internship->id)
            ->whereDate('date', $targetDate)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengisi logbook untuk tanggal tersebut.');
        }

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            // Simpan ke folder: storage/app/public/evidence
            $evidencePath = $request->file('evidence')->store('evidence', 'public');
        }

        // 4. Simpan ke Database
        DailyLogbook::create([
            'internship_id' => $internship->id,
            'date' => $targetDate,
            'title' => $request->title,
            'activity' => $request->activity,
            'evidence' => $evidencePath,
            'status' => 'pending', // Default status menunggu persetujuan mentor
        ]);

        return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil disimpan!');
    }

    /**
     * Menampilkan form edit logbook.
     */
    public function edit($id)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        $logbook = DailyLogbook::where('id', $id)
            ->where('internship_id', $internship->id)
            ->firstOrFail();

        if ($logbook->status === 'approved') {
            return redirect()->route('logbooks.index')->with('error', 'Logbook yang sudah disetujui tidak dapat diubah.');
        }

        return view('logbooks.edit', compact('logbook'));
    }

    /**
     * Memperbarui data logbook ke database.
     */
    public function update(StoreLogbookRequest $request, $id)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        $logbook = DailyLogbook::where('id', $id)
            ->where('internship_id', $internship->id)
            ->firstOrFail();

        if ($logbook->status === 'approved') {
            return redirect()->route('logbooks.index')->with('error', 'Logbook yang sudah disetujui tidak dapat diubah.');
        }

        // Handle Upload File Bukti (Jika ada)
        $evidencePath = $logbook->evidence; // default to old image
        if ($request->hasFile('evidence')) {
            // Hapus evidence lama jika ada
            if ($logbook->evidence && Storage::disk('public')->exists($logbook->evidence)) {
                Storage::disk('public')->delete($logbook->evidence);
            }
            // Simpan ke folder: storage/app/public/evidence
            $evidencePath = $request->file('evidence')->store('evidence', 'public');
        }

        $logbook->update([
            'title' => $request->title,
            'activity' => $request->activity,
            'evidence' => $evidencePath,
            'status' => 'pending', // Kembalikan ke pending agar direview ulang
            'mentor_notes' => null // Hapus notes lama
        ]);

        return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil diperbarui!');
    }

    /**
     * Menghapus logbook.
     */
    public function destroy($id)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        $logbook = DailyLogbook::where('id', $id)
            ->where('internship_id', $internship->id)
            ->firstOrFail();

        if ($logbook->status === 'approved') {
            return redirect()->route('logbooks.index')->with('error', 'Logbook yang sudah disetujui tidak dapat dihapus.');
        }

        // Hapus evidence jika ada
        if ($logbook->evidence && Storage::disk('public')->exists($logbook->evidence)) {
            Storage::disk('public')->delete($logbook->evidence);
        }

        $logbook->delete();

        return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil dihapus!');
    }

    /**
     * Handle Image Upload from Trix Editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048', // Maksimal 2MB, harus gambar
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('logbook-images', 'public');
            return response()->json([
                'url' => Storage::url($path),
            ]);
        }
    }

    /**
     * Export Logbook ke PDF.
     */
    public function exportPdf()
    {
        $internship = Internship::with(['student', 'mentor', 'division'])
            ->where('student_id', Auth::id())
            ->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        $logbooks = DailyLogbook::where('internship_id', $internship->id)
            ->orderBy('date', 'asc')
            ->get();

        $pdf = Pdf::loadView('logbooks.pdf', compact('internship', 'logbooks'));

        return $pdf->download('Logbook_Magang_' . Auth::user()->name . '.pdf');
    }

    /**
     * Export Logbook ke Excel.
     */
    public function exportExcel()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Data magang tidak ditemukan.');
        }

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LogbooksExport($internship),
            'Logbook_Magang_' . Auth::user()->name . '.xlsx'
        );
    }
}