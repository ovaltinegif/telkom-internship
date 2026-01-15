@foreach($internships as $magang)
    <div class="card">
        <p>Mahasiswa: {{ $magang->student->name }}</p>
        
        @if(auth()->user()->id == $magang->mentor_id)
            
            @if($magang->evaluation)
                <span class="text-green-600">Sudah Dinilai</span>
            @else
                <a href="{{ route('evaluations.create', $magang->id) }}" class="text-blue-500 underline">
                    Input Nilai
                </a>
            @endif

        @endif
    </div>
@endforeach