<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | ASR GO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>*{font-family:'Inter',sans-serif}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 flex items-center justify-center p-4">
    <div class="text-center max-w-lg">
        <div class="text-8xl font-extrabold text-red-100 mb-4">500</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Terjadi Kesalahan</h1>
        <p class="text-gray-500 mb-8">Maaf, sedang terjadi masalah teknis. Tim kami sudah notifikasi dan sedang memperbaiki. Silakan coba lagi nanti.</p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="location.reload()" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Coba Lagi
            </button>
            <a href="/" class="px-6 py-3 bg-white text-blue-600 border border-blue-200 rounded-xl font-medium hover:bg-blue-50 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
