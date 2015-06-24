<html>
    <body>
        <form action="" method="post">
            <table>
                <tr><td><b>Olah Kata</b></td></tr>
                <tr><td>Masukkan Kata</td><td>:</td><td><input type="text" name="kata" placeholder="Masukkan Kata..."></td><td><input type="submit" name="proses" value="PROSES"></td></tr>
            </table>
        </form>
        <?php
        include 'cariAcak.php';
        $url = "katadasar.txt";
        $cari = new cariAcak($url);
        if (isset($_POST['proses'])) {
            $kata = strtolower($_POST['kata']);
            $cari->insertYgDcari($kata);
            $cari->mulaiMencari();
            $cari->sorting();
            $cari->output();
            ?>
            <table>
                <tr><td><b>Daftar Huruf</b></td><td>:</td><td><font color="blue"><?php echo kataInput($kata) ?></font></td><td><?php jumlahKarakter($kata) ?></td></tr>
                <tr><td><b>Kata yang dapat disusun</b></td><td>:</td></tr><br>

            </table>
            <table>
                <?php $cari->cetak() ?>
            </table>

            <?php
        }
        ?>
    </body>
</html>
<?php

function kataInput($kata) {
    $arrKata = str_split($kata);
    for ($i = 0; $i < count($arrKata); $i++) {
        echo strtoupper($arrKata[$i] . " ");
    }
}

function jumlahKarakter($kata) {
    $arrKata = str_split($kata);
    echo "(" . count($arrKata) . " Huruf)";
}
?>
