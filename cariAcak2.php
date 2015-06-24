<?php

class cariAcak {

    private $dataInput;
    private $panjangInput;
    private $dataPembanding;
    private $panjangPembanding;
    private $dataOutput;
    private $panjangOutput;
    private $dataSave;
    private $panjangSave;
    private $karakterSave;

    function __construct($url) {
        $this->dataPembanding = array();
        $this->panjangPembanding = array();
        $this->dataOutput = array();
        $this->panjangOutput = array();
        $this->dataSave = array();
        $this->panjangSave = array();
        $this->karakterSave = array();
        $this->insertWordtoMachine($url);
    }

    //Memasukkan data dari file ke dalam mesin
    private function insertWordtoMachine($url) {
        try {
            $file = fopen($url, "r");
            $habis = false;
            while (!$habis) {
                $line = fgets($file);
                if ($line == null) {
                    $habis = true;
                    break;
                } else {
                    //Pecah kata menjadi huruf-huruf
                    $arrPemb = str_split($line);
                    //Hitung jumlah huruf dari kata yang dipecah
                    $panjPemb = count($arrPemb) - 1;
                    //Masukkan kata ke dalam Array
                    array_push($this->dataPembanding, $line);
                    //Masukkan panjang array ke dalam index yang sama dimana kata dimasukkan
                    array_push($this->panjangPembanding, $panjPemb);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //Memasukkan kata yang dicari ke dalam mesin
    public function insertYgDcari($text) {
        //Pecah kata menjadi huruf
        $strSplit = str_split($text);
        //Hitung banyaknya huruf hasil pemecahan kata
        $panjInput = count($strSplit);
        //kondisi : jika kata yang dimasukkan harus diantara 3-13 karakter
        if ($panjInput > 1 && $panjInput < 14) {
            $this->dataInput = $text;
            $this->panjangInput = (int) $panjInput;
        } else {
            echo "Data yang anda masukkan harus diantara 3-13";
        }
    }

    //Mencocokkan 
    public function mulaiMencari() {
        $arrSplit = str_split($this->dataInput);
        sort($arrSplit);
        for ($a = 0; $a < count($this->dataPembanding); $a++) {
            $arrSplit2 = str_split($this->dataPembanding[$a]);
            sort($arrSplit2);
            $temp = $this->panjangPembanding[$a];
            if ($this->panjangPembanding[$a] <= $this->panjangInput) {
                //echo $this->dataPembanding[$a];
                $tempX = -1;
                for ($b = 1; $b < $this->panjangPembanding[$a] + 1; $b++) {
                    $i = $b - 1;
                    $ketemu = false;
                    while (!$ketemu && $i < $this->panjangInput) {
                        if ($arrSplit2[$b] == $arrSplit[$i]) {
                            if ($i == $tempX && $arrSplit2[$b] != $arrSplit[$i+1]) {
                                if($arrSplit[$i+1]==null){
                                    break;
                                } else {
                                    break;
                                }
                            } else {
                                $tempX = $i;
                                $temp = $temp - 1;
                                $ketemu = true;
                                break;
                            }
                        }
                        $i++;
                    }
                }
                if ($temp == 0) {
                    array_push($this->dataOutput, $this->dataPembanding[$a]);
                    array_push($this->panjangOutput, $this->panjangPembanding[$a]);
                } else {
                    
                }
            }
        }
    }

    public function cekKata($kata1, $kata2) {
        $k1 = str_split($kata1);
        $k2 = str_split($kata2);

        for ($i = 0; $i < count($k1); $i++) {
            $indexSave = array();
            $ketemu = false;
            $j = 0;
            while (!$ketemu && $j < count($k2)) {
                if ($k2[$j] == $k1[$i]) {
                    array_push($indexSave, $j);
                    $ketemu = true;
                    break;
                }
                $j++;
            }
        }
    }

    function sorting() {
        $tempV = "";
        $tempK = 0;
        for ($a = 0; $a < count($this->dataOutput) - 1; $a++) {
            for ($b = $a + 1; $b < count($this->dataOutput); $b++) {
                if ($this->panjangOutput[$a] > $this->panjangOutput[$b]) {
                    $tempV = $this->dataOutput[$b];
                    $tempK = $this->panjangOutput[$b];
                    $this->dataOutput[$b] = $this->dataOutput[$a];
                    $this->panjangOutput[$b] = $this->panjangOutput[$a];
                    $this->dataOutput[$a] = $tempV;
                    $this->panjangOutput[$a] = $tempK;
                }
            }
        }
    }

    function output() {
        for ($k = 3; $k < 14; $k++) {
            $i = 0;
            $count = 0;
            $arr = array();
            $svOut = 0;
            while ($i < count($this->dataOutput)) {
                if ($k == $this->panjangOutput[$i]) {
                    array_push($arr, $this->dataOutput[$i]);
                    $svOut = $this->panjangOutput[$i];
                    $count = $count + 1;
                }
                $i++;
            }
            if ($count != 0) {
                array_push($this->dataSave, $arr);
                array_push($this->panjangSave, $count);
                array_push($this->karakterSave, $svOut);
            }
        }
    }

    function cetak() {
        $total = 0;
        for ($a = 0; $a < count($this->panjangSave); $a++) {
            echo "<tr><td>#</td><td><b>" . $this->karakterSave[$a] . " Huruf : </b></td></tr>";
            echo "<tr><td></td><td>";
            for ($b = 0; $b < $this->panjangSave[$a]; $b++) {
                echo "<font color='blue'>" . $this->dataSave[$a][$b] . ",</font>";
            }
            $total = $total + $this->panjangSave[$a];
            echo "<b>(" . $this->panjangSave[$a] . " Kata)</b>";
            echo "</td></tr>";
        }
        echo "</table>";
        echo "<table>";
        echo "<tr><td><b>Total Kata Ditemukan</b></td><td>:</td><td>" . $total . " Kata</td></tr>";
    }

}

?>
