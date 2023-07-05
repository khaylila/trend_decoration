<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi akun Sewadekor.id</title>
    <style>
        .feedbackButton:hover {
            background-color: rgb(21 94 117);
        }
    </style>
</head>

<body width="100%" style="font-family: sans-serif; color: #555555; background-color: #eee;">
    <div style="padding: 20px; background-color: white; width: 600px; margin-left: auto; margin-right: auto;">
        <table cellspacing="0" cellpadding="0" style="padding-left: 20px; padding-right: 20px;">
            <tr>
                <td style="text-align: center;">
                    <img style="width: 10%; border-radius: 50px;" src="<?= base_url(); ?>/img/sewadekorLogo.png" alt="">
                    <img style="width: 50%;" src="<?= base_url(); ?>/img/sewadekorNametag.png" alt="">
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size: 0.85rem;">Kepada <strong>Yth. <?= $fullname; ?></strong></p>
                    <p style="font-size: 0.85rem;">Terimakasih sebelumnya karena telah menggunakan layanan kami. Akun anda telah berhasil diaktifkan. Berikut kami informasikan detail akun website anda</p>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" style="padding-left: 20px; padding-right: 20px;">
            <tr>
                <td style="background-color: #F0F8FF; width: 10%; text-align: center; fill: yellow;">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                    </svg>
                </td>
                <td style="background-color: #F0F8FF; width: 70%;">
                    <p style="font-size: 0.80rem;"><strong>Perhatian: </strong>Pastikan anda mengganti password sesegera mungkin agar akun anda menjadi lebih aman. Jangan pernah membagikan password anda kepada siapapun agar terhindar dari kejahatan pencurian data.</p>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" style="width: 100%; padding-left: 20px; padding-right: 20px; font-size: 0.80rem; margin-top: 20px;">
            <tr>
                <td colspan="2" style="background-color: #eee; border-color: #eee; border-width: 1px; border-style: solid none solid none; text-align: center;">
                    <p><strong>Detail Paket</strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-width: 1px; border-color: #eee; border-style: solid none solid none; font-size: 0.80rem;">
                    <p><strong>Personal untuk <?= $mitraName; ?></strong></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Diaktifkan pada</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: <?= $activeDate; ?></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Kadaluarsa pada</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: -</p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Siklus pembayaran</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: Free (Testing)</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background-color: #eee; border-width: 1px; border-color: #eee; border-style: none none solid none; text-align: center;">
                    <p><strong>Informasi Akun</strong></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Domain</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: <a href="<?= base_url(); ?>"><?= base_url(); ?></a></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Email</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: <?= $email; ?></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>Password</p>
                </td>
                <td style="width: 70%; border-width: 1px; border-color: #eee; border-style: none none solid none;">
                    <p>: <?= $password; ?></p>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" style="padding-left: 20px; padding-right: 20px;">
            <tr>
                <td>
                    <p style="font-size: 0.85rem; margin-bottom: 50px;">Masukkan anda sangat berarti bagi kami untuk meningkatkan pengalaman anda dalam menggunakan layanan kami.</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <a class="feedbackButton" style="padding: 1rem 1rem; background-color: rgb(6 182 212); border-radius: 5px; color: white; text-decoration: none;" href="mailto:cs@sewadekor.id">Tambah Feedback!</a>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size: 0.85rem; margin-top: 50px;">Hormat kami,
                        <br>
                        Sewadekor.id
                        <br>
                        <a href="<?= base_url(); ?>"><?= base_url(); ?></a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <div style="background-color: #eee; width: 600px; margin-left: auto; margin-right: auto;">
        <div style="padding: 20px 40px; font-size: 0.80rem; text-align: center;">
            <p><strong>Sewadekor.id dioptimalkan sebagai aplikasi Point Of Sales (POS) untuk mengelola seputar Dekorasi Pernikahan dan Tenda serta Sound System, lalu kemudian akan dikembangkan sebagai Toko Persewaan Online</strong></p>

            <p style="padding-left: 20px; padding-right: 20px;">Kami menyediakan layanan Customer Service 24 jam untuk membantu anda jika terjadi kesulitan, gratis!</p>

            <p><a href="mailto:cs@sewadekor.id">Email: cs@sewadekor.id</a></p>
        </div>
    </div>
    <div style="background-color: white; width: 600px; margin-left: auto; margin-right: auto;">
        <p style="font-size: 0.70rem; padding: 20px 50px; text-align: center;">Email ini bersifat informasi, tidak dapat dibalas. Informasi lebih lanjut, silakan hubungi customer care kami di cs@sewadekor.id</p>
    </div>
</body>

</html>