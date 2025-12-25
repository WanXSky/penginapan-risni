@extends('layouts.app')

@section('title', 'Peraturan Penginapan - Penginapan Risni')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-28">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Peraturan Penginapan</h1>
        <p class="text-lg md:text-xl">Mohon dibaca dengan seksama sebelum melakukan reservasi</p>
    </div>
</section>

<!-- Important Notice -->
<section class="bg-yellow-50 border-l-4 border-yellow-400 p-6 my-8 container mx-auto">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-yellow-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
        <div>
            <h3 class="text-lg font-bold md:text-3xl text-yellow-800 mb-2 text-center">TAMU WAJIB MEMBAWA/MENUNJUKKAN KTP SAAT MELAKUKAN RESERVASI</h3>
            <p class="text-yellow-700 font-semibold text-center">TIDAK MENERIMA SHORT TIME / TRANSIT</p>
        </div>
    </div>
</section>

<!-- Rules Content -->
<section class="container mx-auto px-4 py-">
    <div class="max-w-4xl mx-auto">
        
        <!-- Main Rules Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="border-b-4 border-blue-500 pb-4 mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center">PERATURAN PENGINAPAN</h2>
                <p class="text-center text-gray-600 mt-2">Penginapan Risni Bone-Bone</p>
            </div>

            <div class="space-y-4">
                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">1</span>
                    <p class="text-gray-700 leading-relaxed">Tamu dapat menggunakan dapur untuk memasak makanan atau membuat minuman</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">2</span>
                    <p class="text-gray-700 leading-relaxed">Tamu tidak diperkenankan membawa pulang milik penginapan yang ada di dalam kamar penginapan</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">3</span>
                    <p class="text-gray-700 leading-relaxed">Tamu diperkenankan membawa makanan dari luar</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">4</span>
                    <p class="text-gray-700 leading-relaxed">Tidak diperkenankan membawa senjata tajam dengan bau menyengat</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">5</span>
                    <p class="text-gray-700 leading-relaxed">Tidak diperkenankan membawa seperti durian, cempedak, serta di dalam kamar penginapan dan minuman keras, obat terlarang dan narkotika di dalam kamar penginapan dan atau lingkungan sekitar penginapan</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">6</span>
                    <p class="text-gray-700 leading-relaxed">Pria dan wanita yang bukan pasangan resmi (suami dan istri) tidak diperkenankan berada dalam kamar penginapan</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">7</span>
                    <p class="text-gray-700 leading-relaxed">Pelajar/siswa tidak boleh berada dalam lingkungan penginapan</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">8</span>
                    <p class="text-gray-700 leading-relaxed">Anak berumur 10 tahun ke bawah tidak boleh berada dalam kamar penginapan tanpa pengawasan orang tua</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">9</span>
                    <p class="text-gray-700 leading-relaxed">Tidak diperkenankan melakukan tindak kekerasan dan atau perkelahian di dalam lingkungan penginapan</p>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">10</span>
                    <p class="text-gray-700 leading-relaxed">Tidak diperkenankan melakukan hal-hal yang berlawanan dengan norma atau melakukan tindakan asusila / prostitusi di dalam kamar penginapan</p>
                </div>
            </div>

            <div class="mt-8 p-6 bg-red-50 border-l-4 border-red-500 rounded">
                <p class="text-red-800 font-bold text-lg mb-2">PERHATIAN!</p>
                <p class="text-red-700">Semua tindakan yang melawan hukum dan kegiatan yang berlawanan dengan norma sosial/asusila, akan dilaporkan kepada pihak yang berwajib (Kepolisian)</p>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600 italic">Salam Hormat,</p>
                <p class="text-gray-800 font-semibold mt-2">Management Penginapan Risni Bone-Bone</p>
            </div>
        </div>

        <!-- Additional Information Cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Room Capacity -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-red-600 mb-4 border-b-2 border-red-200 pb-2">PERHATIAN !!!</h3>
                <div class="space-y-3">
                    <p class="text-gray-700"><span class="font-bold">1 KAMAR MAKSIMUM 3 ORANG.</span></p>
                    <p class="text-gray-700"><span class="font-bold text-red-600">DILARANG</span> MENGOPERKAN KAMAR KE ORANG LAIN!</p>
                </div>
            </div>

            <!-- Operating Hours -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-blue-600 mb-4 border-b-2 border-blue-200 pb-2">Jam Operasional</h3>
                <div class="space-y-3">
                    <p class="text-gray-700"><span class="font-bold">Jam 12 Malam Pintu Pagar Ditutup/Kunci</span></p>
                    <p class="text-gray-700">Dibuka Lagi <span class="font-bold">Jam 5 Pagi</span></p>
                </div>
            </div>
        </div>

        <!-- Agreement Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Persetujuan</h3>
            
            <form id="agreementForm" class="space-y-6">
                <div class="flex items-start">
                    <input type="checkbox" id="agreeTerms" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                    <label for="agreeTerms" class="ml-3 text-gray-700">
                        Saya telah membaca dan menyetujui semua peraturan penginapan yang berlaku di Penginapan Risni Bone-Bone
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" id="bringKTP" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                    <label for="bringKTP" class="ml-3 text-gray-700">
                        Saya akan membawa KTP (Kartu Tanda Penduduk) saat melakukan check-in
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" id="responsibility" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                    <label for="responsibility" class="ml-3 text-gray-700">
                        Saya bertanggung jawab penuh atas segala tindakan yang dilakukan selama menginap dan bersedia menanggung konsekuensi jika melanggar peraturan
                    </label>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <button type="button" onclick="window.location.href='/'" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                        Kembali
                    </button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        Setuju & Lanjutkan Reservasi
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

<script>
document.getElementById('agreementForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const agreeTerms = document.getElementById('agreeTerms').checked;
    const bringKTP = document.getElementById('bringKTP').checked;
    const responsibility = document.getElementById('responsibility').checked;
    
    if (agreeTerms && bringKTP && responsibility) {
        alert('Terima kasih telah menyetujui peraturan penginapan.\n\nAnda akan dialihkan ke halaman reservasi.');
        // Redirect to booking page or home
        window.location.href = '/';
    } else {
        alert('Mohon centang semua persetujuan untuk melanjutkan.');
    }
});
</script>
@endsection
