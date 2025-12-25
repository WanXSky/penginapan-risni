<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $pembayaran->reservasi->generateBookingId() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Added print styles to hide buttons and optimize layout for single page */
        @media print {
            .no-print { 
                display: none !important; 
            }
            body { 
                print-color-adjust: exact; 
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }
            .print-container {
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }
            .print-content {
                page-break-inside: avoid;
                padding: 20px !important;
            }
            /* Remove page margins in print */
            @page {
                margin: 10mm;
            }
        }
        /* Compact layout for better single page fit */
        .compact-section {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-8 print-container">
        <!-- Action buttons - hidden in print -->
        <div class="mb-6 no-print flex justify-end gap-3">
            <button onclick="window.print()" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                Unduh Invoice
            </button>
            <button onclick="window.close()" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium transition">
                Tutup
            </button>
        </div>

        <!-- Professional invoice layout -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden print-content">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 compact-section">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('penginapanrisni/test.png') }}" alt="Logo Penginapan Risni" class="h-16 w-16 bg-white rounded-lg p-2">
                        <div>
                            <h1 class="text-2xl font-bold">PENGINAPAN RISNI</h1>
                            <p class="text-blue-100 text-sm mt-1">Jl. Trans Sulawesi</p>
                            <p class="text-blue-100 text-sm">(+62)-82320532665</p>
                            <p class="text-blue-100 text-sm">penginapanrisni@gmail.com</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold mb-1">INVOICE</div>
                        <div class="text-blue-100">
                            <p class="font-semibold">{{ $pembayaran->reservasi->generateBookingId() }}</p>
                            <p class="text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Customer Info -->
                <div class="mb-6 pb-4 border-b-2 border-gray-200 compact-section">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Tamu</h3>
                            <p class="text-base font-bold text-gray-900">{{ $pembayaran->reservasi->nama_lengkap }}</p>
                            <p class="text-sm text-gray-600">{{ $pembayaran->reservasi->email }}</p>
                            <p class="text-sm text-gray-600">{{ $pembayaran->reservasi->no_telp }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Status Pembayaran</h3>
                            <span class="inline-block px-3 py-1.5 bg-green-100 text-green-800 rounded-full font-bold text-sm">
                                ✓ LUNAS
                            </span>
                            <p class="text-xs text-gray-600 mt-2">
                                Diverifikasi: {{ \Carbon\Carbon::parse($pembayaran->verified_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details Table -->
                <div class="mb-6 compact-section">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-3">Detail Reservasi</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                <th class="text-left py-2 px-3 font-semibold text-gray-700 text-sm">Deskripsi</th>
                                <th class="text-center py-2 px-3 font-semibold text-gray-700 text-sm">Check-in</th>
                                <th class="text-center py-2 px-3 font-semibold text-gray-700 text-sm">Check-out</th>
                                <th class="text-center py-2 px-3 font-semibold text-gray-700 text-sm">Durasi</th>
                                <th class="text-right py-2 px-3 font-semibold text-gray-700 text-sm">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-3">
                                    <p class="font-semibold text-gray-900">{{ $pembayaran->reservasi->kamar->tipe }}</p>
                                    <!-- Display nama_kamar directly -->
                                    <p class="text-xs text-gray-600">
                                        {{ $pembayaran->reservasi->kamar->nama_kamar }}
                                    </p>
                                </td>
                                <td class="text-center py-3 px-3 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($pembayaran->reservasi->check_in)->locale('id')->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center py-3 px-3 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($pembayaran->reservasi->check_out)->locale('id')->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center py-3 px-3 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($pembayaran->reservasi->check_in)->diffInDays(\Carbon\Carbon::parse($pembayaran->reservasi->check_out)) }} malam
                                </td>
                                <td class="text-right py-3 px-3 font-semibold text-gray-900">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="flex justify-end mb-6 compact-section">
                    <div class="w-80">
                        <div class="flex justify-between py-2 border-t border-gray-200">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-t-2 border-gray-300 bg-gray-50 px-3 rounded-lg">
                            <span class="text-base font-bold text-gray-900">TOTAL</span>
                            <span class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 mb-6 compact-section">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 002-2H4z"/>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold text-gray-700 text-sm">Metode Pembayaran: </span>
                        <span class="ml-2 text-gray-900 text-sm">
                            @if($pembayaran->metode === 'transfer')
                                Transfer Bank BCA
                            @elseif($pembayaran->metode === 'qris')
                                QRIS
                            @else
                                Cash/Tunai
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Footer Notes -->
                <div class="border-t-2 border-gray-200 pt-4">
                    <div class="text-center text-gray-600">
                        <p class="font-semibold text-gray-900 mb-1 text-sm">Terima kasih atas kepercayaan Anda menginap di Penginapan Risni</p>
                        <p class="text-xs">Invoice ini merupakan bukti sah pembayaran yang dihasilkan secara elektronik.</p>
                        <p class="text-xs mt-1">Untuk pertanyaan lebih lanjut, silakan hubungi kami di nomor telepon atau email di atas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print if query param is present
        if (window.location.search.includes('autoprint=1')) {
            window.onload = () => window.print();
        }
    </script>
</body>
</html>
