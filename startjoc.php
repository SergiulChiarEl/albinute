<?php

if (isset($_POST['submit']))
{
    $nume = $_POST['nume'];
}
session_start();
class Game
{
    public function __construct()
    {

    }

    public function play()
    {
        return '<input type="button" value="Play" onclick="window.location = \'?play=1\'">';
    }
    public function start($msg = null)
    {
        unset($_SESSION['albine']);
        $albina = new albina();
        $albina->setType('queen');
        $this->addalbina($albina, 1);
        $albina->setType('worker');
        $this->addalbina($albina, 5);
        $albina->setType('drone');
        $this->addalbina($albina, 8);
        if ($msg) return $msg;
        else
        {

            // var_dump($_SESSION['albine']); // debug
            return 'Game started <br><input type="button" value="Hit" onclick="window.location = \'?hit=1\'">';

        }
    } //incepem jocul cu o aliba 'Queen', 5 'worker' si 8 'drone'
    

    public function hit()
    {

        $nume = 'Player'; //numele Player-ului
        $msg = '';
        //       $hptotalqueen=$_SESSION['albine']['queen']['hp'];
        // $hptotaldrone=($_SESSION['albine']['drone']['hp'])*($_SESSION['albine']['drone']['albine']);
        // $hptotalworker=($_SESSION['albine']['worker']['hp'])*($_SESSION['albine']['worker']['albine']);
        // $hptotal=$hptotalworker+$hptotaldrone+$hptotalqueen; rip
        

        if ($_SESSION['albine'])

        $rd = array_rand($_SESSION['albine'], 1);

        else

        $this->start('Jocul va reincepe');

        echo 'O albina ' . $rd . ' a luat ' . $_SESSION['albine'][$rd]['hit'] . ' damage. '; //Ultimul atac
        // echo '<br>HP total stup ' . $hptotal . ''; rip
        $_SESSION['albine'][$rd]['hp'] = $_SESSION['albine'][$rd]['hp'] - $_SESSION['albine'][$rd]['hit']; //update-ul dupa ultimul atac
        

        if ($_SESSION['albine'][$rd]['hp'] < 1)
        {
            $_SESSION['albine'][$rd]['albine'] -= 1; //daca moare o albina, totalul de albine de acel tip scade cu 1.
            $_SESSION['albine'][$rd]['hp'] = $_SESSION['albine'][$rd]['hp'];

            switch ($rd)
            {
                case 'queen':
                    $msg .= $this->start('<br><br> Albina Queen a murit, iar jocul a reinceput');
                break;
                default:
                    $msg .= '<br><br> O albina \'' . $rd . '\' a murit :( ';

            }
        } //In cazul in care moare albina 'Queen'
        

        if ($_SESSION['albine'][$rd]['albine'] < 1)
        {
            unset($_SESSION['albine'][$rd]);

            $msg = '<br><br> Toate albinele \'' . $rd . '\' au murit :( ';
        } //Dupa ce mor toate albinele de un anumit tip
        else if ($_SESSION['albine'][$rd]['albine'] >= 1)
        {
            echo '<br><br> Albine \'' . $rd . '\' in viata - ';
            print_r($_SESSION['albine'][$rd]['albine']);

        } //arata cate albine din tipul lovit au mai ramas
        // var_dump($_SESSION['albine']); // debug
        echo "<br><br>";
        print_r($_SESSION['albine']); //afisez statusul stupului
        echo '<br><br> Player \'' . $nume . '\' ';

        // echo "<br><br> Albine 'drone' in viata"; print_r(($_SESSION['albine']['drone']['albine'])*($_SESSION['albine']['drone']['hp']));
        

        return '<br><input type="button" value="Hit" onclick="window.location = \'?hit=1\'"> ' . $msg;
        print ($_SESSION["albine"][$rd]["hp"]); //
        
    }

    public function addalbina(albina $newalbina, $number = 1)
    {
        $tipo = $newalbina->getType();
        $albina = $newalbina->get();
        $_SESSION['albine'][$tipo] = $albina;
        $_SESSION['albine'][$tipo]['albine'] = $number;
        $_SESSION['albine'][$tipo]['hp'] = $newalbina->gethp($tipo);
    }
} //adaugarea albinelor
class albina
{
    protected $_type = null;
    protected $_types = array(
        'queen' => array(
            'hit' => 8,
            'hp' => 100
        ) ,
        'worker' => array(
            'hit' => 10,
            'hp' => 75
        ) ,
        'drone' => array(
            'hit' => 12,
            'hp' => 50
        )
    );
    public function setHit()
    {
    }
    public function sethp()
    {
    }
    public function addNewType()
    {
    }
    protected function _set_hit()
    {
    }
    protected function _set_hp()
    {
    }
    protected function _add_new_type()
    {
    }
    public function gethp($type)
    {
        if (array_key_exists($type, $this->_types)) return $this->_types[$this->_type]['hp'];
        else throw new Exception('O albina poate fi Queen, drone sau worker');
    }
    public function getTypes()
    {
        return $this->_types;
    }
    public function getType()
    {
        return $this->_type;
    }
    public function setType($type)
    {
        if (array_key_exists($type, $this->_types)) $this->_type = $type;
        else throw new Exception('O albina poate fi Queen, drone sau worker');
    }
    public function get()
    {
        return $this->_types[$this->_type];
    }
}
?>
<html>
<head>
<title>play albine</title>
</head>
<body>



    <?php

$game = new Game(); //start joc
if (isset($_GET['play']) && $_GET['play'])
{
    echo $game->start();
}
else if (isset($_GET['hit']) && $_GET['hit'])
{
    echo $game->hit();
}
else
{
    {
        echo $game->play();
    }
}
?>
  
</body>
</html>
