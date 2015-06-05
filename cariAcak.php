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
                    $arrPemb = str_split($line);
                    $panjPemb = count($arrPemb) - 1;
                    array_push($this->dataPembanding, $line);
                    array_push($this->panjangPembanding, $panjPemb);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function insertYgDcari($text) {
        $strSplit = str_split($text);
        $panjInput = count($strSplit);
        if ($panjInput > 1 && $panjInput < 13) {
            $this->dataInput = $text;
            $this->panjangInput = (int) $panjInput;
        } else {
            echo "Data yang anda masukkan harus diantara 3-13";
        }
    }

    public function mulaiMencari() {
        $temp = 0;

        $arrSplit = str_split($this->dataInput);
        for ($a = 0; $a < count($this->dataPembanding); $a++) {
            $temp2 = $this->panjangPembanding[$a];
            $arrSplit2 = str_split($this->dataPembanding[$a]);
            for ($b = 0; $b < $this->panjangInput; $b++) {
                for ($c = 0; $c < $this->panjangPembanding[$a]; $c++) {
                    if ($arrSplit[$b] == $arrSplit2[$c]) {
                        $temp2 = $temp2 - 1;
                        break;
                    }
                }continue;
            }
            if ($temp2 == 0) {
                array_push($this->dataOutput, $this->dataPembanding[$a]);
                array_push($this->panjangOutput, $this->panjangPembanding[$a]);
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
