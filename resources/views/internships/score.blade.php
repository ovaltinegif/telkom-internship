<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">Hasil Evaluasi Magang</h2>

    @if($evaluation)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded">
                <span class="block text-gray-500">Kedisiplinan</span>
                <span class="text-2xl font-bold">{{ $evaluation->discipline_score }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <span class="block text-gray-500">Kemampuan Teknis</span>
                <span class="text-2xl font-bold">{{ $evaluation->technical_score }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <span class="block text-gray-500">Soft Skill</span>
                <span class="text-2xl font-bold">{{ $evaluation->soft_skill_score }}</span>
            </div>
            <div class="bg-blue-50 p-4 rounded border border-blue-200">
                <span class="block text-blue-500">Nilai Akhir</span>
                <span class="text-3xl font-bold text-blue-700">{{ $evaluation->final_score }}</span>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold">Feedback Mentor:</h3>
            <p class="text-gray-700 mt-2 p-4 bg-gray-50 rounded italic">
                "{{ $evaluation->feedback }}"
            </p>
        </div>
    @else
        <div class="text-center py-10 text-gray-500">
            <p>Belum ada nilai yang diinput oleh mentor.</p>
        </div>
    @endif
</div>