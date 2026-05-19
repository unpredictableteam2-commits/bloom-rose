<?php
session_start();

// 1. DATASET PERCAKAPAN (15 LANGKAH)
$dataset = [
    'Ekonomi' => [
        1 => ["t" => "Hai! Pernah ngerasain harga jajanan naik tiba-tiba? Menurutmu kenapa itu bisa terjadi?", "o" => ["Stok lagi sedikit", "Banyak yang mau beli", "Barangnya susah dicari"]],
        2 => ["t" => "Betul! Itu disebut Kelangkaan. Kalau pembeli makin banyak tapi barang tetap dikit, pedagang bakal ngapain?", "o" => ["Penjual bakal naikin harga", "Harganya jadi lebih mahal"]],
        3 => ["t" => "Tepat! Harga naik karena barang jadi rebutan. Kalau sudah mahal banget, kamu bakal tetap beli atau cari merk lain?", "o" => ["Cari barang pengganti", "Mending hemat dulu"]],
        4 => ["t" => "Cerdas! Itu namanya Barang Substitusi. Nah, kalau semua harga barang naik secara bersamaan, kamu tau disebut apa?", "o" => ["Itu namanya Inflasi", "Kenaikan harga umum"]],
        5 => ["t" => "Pintar! Inflasi bikin uang jajan kita terasa 'berkurang' nilainya. Menurutmu, apa dampak inflasi buat pelajar?", "o" => ["Jajan jadi lebih sedikit", "Harus lebih rajin nabung"]],
        6 => ["t" => "Setuju! Oh ya, kalau kamu punya uang 50rb, lebih baik beli buku sekolah atau beli skin game?", "o" => ["Beli buku sekolah", "Beli skin game"]],
        7 => ["t" => "Wah, itu namanya Skala Prioritas. Kenapa kamu mendahulukan pilihan itu?", "o" => ["Karena lebih butuh", "Karena lebih penting"]],
        8 => ["t" => "Bagus! Kamu sudah bisa membedakan Kebutuhan dan Keinginan. Menurutmu, pulsa HP itu kebutuhan atau keinginan?", "o" => ["Kebutuhan (buat belajar)", "Keinginan (buat main)"]],
        9 => ["t" => "Menarik! Setiap orang punya alasan beda. Ngomong-ngomong, kamu pernah nabung di celengan atau bank?", "o" => ["Nabung di celengan", "Nabung di bank"]],
        10 => ["t" => "Keren! Menabung itu bagian dari investasi masa depan. Kamu tau gak apa itu investasi?", "o" => ["Menanam modal", "Menyimpan uang untuk untung"]],
        11 => ["t" => "Betul banget! Investasi gak cuma uang, belajar pun investasi leher ke atas. Pernah dengar istilah Pasar?", "o" => ["Tempat jual beli", "Pertemuan penjual & pembeli"]],
        12 => ["t" => "Tepat. Di era digital, apakah marketplace (Shopee/Tokopedia) bisa disebut pasar?", "o" => ["Ya, itu pasar digital", "Tentu saja"]],
        13 => ["t" => "Cerdas! Sekarang pasar gak harus ketemu fisik. Menurutmu, belanja online bikin kita lebih boros gak?", "o" => ["Iya, jadi pengen beli terus", "Tergantung kitanya"]],
        14 => ["t" => "Sangat bijak. Diskusi kita sudah sangat dalam nih. Ada lagi yang mau kamu tanyakan soal Ekonomi?", "o" => ["Gimana cara ngatur uang?", "Gak ada, sudah paham"]],
        15 => ["t" => "Cara terbaik adalah 40-30-20-10 (Konsumsi-Tabung-Kebaikan-Darurat). Sesi selesai! Ada lagi?", "o" => ["Terima kasih, Bloom Rose!", "Cukup untuk hari ini"]]
    ]
];

// 2. LOGIKA STATE & RESET
if (!isset($_SESSION['page'])) $_SESSION['page'] = 1;
if (!isset($_SESSION['step'])) $_SESSION['step'] = 1;

if (isset($_GET['action']) && $_GET['action'] == 'exit') {
    session_destroy();
    header("Location: index.php"); exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'start') {
    $_SESSION['page'] = 3;
    $_SESSION['step'] = 1;
    unset($_SESSION['chat_history']);
    header("Location: index.php?sub=" . $_GET['sub']); exit();
}

// 3. LOGIKA CHAT (KUNCI UTAMA ANTI-LOOPING)
if (isset($_POST['send_msg'])) {
    $sub = $_GET['sub'] ?? 'Ekonomi';
    $userMsg = $_POST['user_input'];
    
    // Simpan chat user
    $_SESSION['chat_history'][] = ['s' => 'u', 'm' => $userMsg];

    // Naikkan step agar tidak mengulang pertanyaan yang sama
    $_SESSION['step']++;
    $currentStep = $_SESSION['step'];

    if (isset($dataset[$sub][$currentStep])) {
        $aiMsg = $dataset[$sub][$currentStep]['t'];
        $opts = $dataset[$sub][$currentStep]['o'];
    } else {
        $aiMsg = "Terima kasih sudah belajar bersamaku hari ini! Kamu hebat. 🌸";
        $opts = [];
    }

    $_SESSION['chat_history'][] = ['s' => 'ai', 'm' => $aiMsg, 'o' => $opts];
    header("Location: index.php?sub=$sub"); exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blossom Ròse AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden h-[700px] flex flex-col">
        
        <?php if ($_SESSION['page'] == 1): ?>
            <div class="m-auto text-center p-10">
                <h1 class="text-4xl font-black text-pink-600">🌸 s</h1>
                <p class="text-[10px] font-bold opacity-30 uppercase tracking-widest mt-2 mb-10">Adaptive AI Tutor</p>
                <a href="?action=start&sub=Ekonomi" class="bg-pink-500 text-white px-10 py-4 rounded-2xl font-black shadow-lg block">Mulai Belajar Ekonomi</a>
            </div>

        <?php elseif ($_SESSION['page'] == 3): $sub = $_GET['sub']; ?>
            <div class="p-5 border-b flex justify-between items-center bg-white">
                <div>
                    <h2 class="font-black text-pink-600 text-sm"><?= $sub ?></h2>
                    <p class="text-[9px] font-bold text-gray-400 uppercase">Tahap <?= $_SESSION['step'] ?> dari 15</p>
                </div>
                <a href="?action=exit" class="text-[10px] font-black text-red-400">KELUAR</a>
            </div>

            <div id="chatbox" class="flex-grow p-4 overflow-y-auto bg-gray-50 space-y-4">
                <?php 
                if (!isset($_SESSION['chat_history'])) {
                    $start = $dataset[$sub][1];
                    $_SESSION['chat_history'][] = ['s' => 'ai', 'm' => $start['t'], 'o' => $start['o']];
                }
                foreach ($_SESSION['chat_history'] as $c): ?>
                    <div class="flex <?= $c['s'] == 'ai' ? 'justify-start' : 'justify-end' ?>">
                        <div class="max-w-[85%] p-4 rounded-3xl text-sm shadow-sm <?= $c['s'] == 'ai' ? 'bg-white text-gray-800' : 'bg-pink-500 text-white' ?>">
                            <?= $c['m'] ?>
                            <?php if ($c['s'] == 'ai' && !empty($c['o'])): ?>
                                <div class="mt-4 space-y-2">
                                    <?php foreach ($c['o'] as $opt): ?>
                                        <button onclick="sendOption('<?= $opt ?>')" class="w-full text-left bg-pink-50 text-pink-600 p-3 rounded-2xl border border-pink-100 text-[11px] font-bold hover:bg-pink-100 transition"><?= $opt ?></button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <form action="" method="POST" id="chat-form" class="p-4 bg-white border-t flex gap-2">
                <input type="text" name="user_input" id="user-input" class="flex-grow bg-gray-100 rounded-2xl px-4 py-3 text-sm focus:outline-none" placeholder="Balas Bloom Rose...">
                <button type="submit" name="send_msg" class="bg-pink-500 text-white px-6 rounded-2xl font-black text-xs">KIRIM</button>
            </form>
        <?php endif; ?>

    </div>

    <script>
        const cb = document.getElementById("chatbox");
        if(cb) cb.scrollTop = cb.scrollHeight;
        function sendOption(v) { document.getElementById('user-input').value = v; document.getElementById('chat-form').submit(); }
    </script>
</body>
</html>