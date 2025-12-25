@extends('layouts.app')

@section('title', 'Hubungi Kami - Penginapan Risni')

@section('content')

<section class="pt-32 pb-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <!-- ================= JUDUL ================= -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">
                Kontak Kami
            </h1>
            <p class="mt-4 text-gray-600">
                Hubungi kami dengan mudah melalui WhatsApp
            </p>
        </div>

        <!-- ================= WHATSAPP FORM ================= -->
        <div class="max-w-3xl mx-auto mb-20">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 space-y-6 shadow">

                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Chat via WhatsApp
                    </h2>
                    <p class="text-gray-600">
                        Isi format di bawah, pesan akan terbuat otomatis
                    </p>
                </div>

                <!-- PREVIEW FORMAT -->
                <div class="bg-gray-50 border rounded-xl p-4 text-sm text-gray-700">
                    <p class="font-semibold mb-2">Format Pesan WhatsApp:</p>
                    <p>Halo admin, aku mau nanya:</p>
                    <p>- <span id="previewQuestion">[pilih pertanyaan]</span></p>
                    <p>Tanggal menginap: <span id="previewDate">[opsional]</span></p>
                    <p>Jumlah kamar: <span id="previewRoom">[opsional]</span></p>
                </div>

                <!-- FORM -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Jenis Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <select id="question" onchange="updatePreview()"
                        class="w-full rounded-xl border-gray-300">
                        <option value="">-- Pilih Pertanyaan --</option>
                        <option value="Harga kamar">Harga kamar</option>
                        <option value="Ketersediaan kamar">Ketersediaan kamar</option>
                        <option value="Fasilitas penginapan">Fasilitas penginapan</option>
                        <option value="Lokasi dan akses">Lokasi dan akses</option>
                        <option value="Cara pemesanan">Cara pemesanan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Tanggal Menginap (opsional)
                    </label>
                    <input type="date" id="date" oninput="updatePreview()"
                        class="w-full rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Jumlah Kamar (opsional)
                    </label>
                    <input type="number" id="room" min="1" placeholder="Contoh: 2"
                        oninput="updatePreview()"
                        class="w-full rounded-xl border-gray-300">
                </div>

                <!-- BUTTON -->
                <button onclick="sendWhatsApp()"
                    class="w-full bg-green-600 hover:bg-green-700 text-white
                           py-4 rounded-xl font-semibold transition shadow-lg">
                    Kirim Pesan WhatsApp
                </button>

                <p class="text-center text-sm text-gray-500">
                    WhatsApp Admin:
                    <span class="font-semibold">+62 823-2053-2665</span>
                </p>
            </div>
        </div>

        <!-- ================= MAP SECTION ================= -->
        <div class="max-w-5xl mx-auto">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800">
                    Lokasi Penginapan Risni Bone-Bone
                </h2>
            </div>

            <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden shadow-lg">
                <div class="aspect-video w-full">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3985.7014639066783!2d120.53230607312182!3d-2.603042638479178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d91a1c2e4b5156b%3A0x183dd7702016eb39!2sPenginapan%20Risni!5e0!3m2!1sid!2sid!4v1766318542356!5m2!1sid!2sid"
                        class="w-full h-full border-0"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
function updatePreview() {
    document.getElementById('previewQuestion').innerText =
        document.getElementById('question').value || '[pilih pertanyaan]';

    document.getElementById('previewDate').innerText =
        document.getElementById('date').value || '[opsional]';

    document.getElementById('previewRoom').innerText =
        document.getElementById('room').value || '[opsional]';
}

function sendWhatsApp() {
    const phone = '6282320532665';
    const q = document.getElementById('question').value;
    const d = document.getElementById('date').value;
    const r = document.getElementById('room').value;

    if (!q) {
        alert('Silakan pilih jenis pertanyaan.');
        return;
    }

    let message = `Halo admin, aku mau nanya:%0A- ${q}`;
    if (d) message += `%0ATanggal menginap: ${d}`;
    if (r) message += `%0AJumlah kamar: ${r}`;

    window.open(
        `https://api.whatsapp.com/send?phone=${phone}&text=${message}`,
        '_blank'
    );
}
</script>
@endpush
