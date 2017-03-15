
<?php
$msg = '';
$tbl = 'ricevute';
$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
$record = (empty($_REQUEST['id'])) ? R::dispense($tbl) : R::load($tbl, intval($_REQUEST['id']));

$data = R::findAll($tbl, 'ORDER by id ASC LIMIT 999');
$clienti = R::findAll('clienti');

if (!empty($_POST['clienti_id'])) :

    $data = R::find($tbl, 'where clienti_id=' . $_POST['clienti_id']);
    echo $_POST['clienti_id'];
    if (empty($data)):
        echo '<h3 class="text-center">Non ci sono ricevute salvate per questo cliente</h3>';
    endif;

endif;

$sum = 0;
foreach ($data as $r):
    $sum += $r->importo;
endforeach;



//$errorMessage = !empty($_POST['data_start']) && !empty($_POST['data_end']) && !$validData ?
//        "La data di inizio ricerca non può essere successiva alla data finale" : "";

if ((!empty($_POST['data_start'])) && (!empty($_POST['data_end']))/* && $validData */) :
    //$validData = $_POST['data_end'] >= $_POST['data_start'];
    //$data=R::find($tbl, "where dataemissione between '1980-02-25' and '2017-02-27' ");
    $data = R::find($tbl, "where dataemissione between '" . $_POST['data_start'] . "' and '" . $_POST['data_end'] . "'");

    if (empty($data)):
        echo '<h3 class="text-center">Non ci sono ricevute salvate per questo periodo</h3>';
    endif;
    echo $_POST['data_start'] . "start<br/>";
    echo $_POST['data_end'] . "end";
endif;
?>


<div class='container'>
    <h3>
        <a href='index.php'>
            Torna alla Home page
        </a>

    </h3>
    <?php if ($id) : ?>
        <a href='?p=ricevuta2'>Ritorna all'elenco</a>
        <h1> Ricevuta numero: <?= $record->numero ?></h1>
        <p class='text-right'>
            emessa in data<?= ($record->dataemissione) ?>
        </p>
        <p>
            Dati di fatturazione <?= ($record->nome) ?>
        </p>
        <div class='panel'>
            Descrizione 
            <div class='panel-body'>
                <p><?= ($record->descrizione) ?></p>
                <p>Costo: <?= ($record->importo) ?></p>
            </div>

        </div>
        <div class='panel'>
            Informazioni sul cliente <?= ($r->nome) ?>
            <div class='panel-body'>
                <p>Email<?= ($record->email) ?></p>
                <p>Telefono <?= ($record->telefono) ?></p>
                <p>Indirizzo <?= ($record->residenza) ?></p>
            </div>

        </div>

    <?php else: ?>
        <a href="?p=ricevute">Elenco modificabile</a>

        <h1>ELENCO DETTAGLIATO</h1>

        <br/>
        <h3>Cerca</h3>
        <form action="?p=ricevuta2" method="post">
            <label for='clienti_id'>
                ricerca per cliente
            </label>
            <select name="clienti_id">
                <?php foreach ($clienti as $opt) : ?>
                    <option value="<?= $opt->id ?>" <?= ($opt->id == $record->clienti_id) ? 'selected' : '' ?> >
                        <?= $opt->nome ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" tabindex="-1">
                Cerca
            </button>
        </form>
        <form action='?p=ricevuta2' method="post">
            <label for='data_start'>
                ricerca per data da:
            </label> 

            <input name="data_start"  value="<?= date('Y-m-d', strtotime($data_start)) ?>" type="date" />
            <label for='data_end'>
                a:
            </label> 

            <input name="data_end" value="<?= date('Y-m-d', strtotime($data_end)) ?>" type="date" />
            <button type="submit" tabindex="-1">
                Cerca
            </button>
        </form>
        <a href="?p=ricevuta2" >
            Elenco Completo
        </a>



        <h3>Somma ricevute selezionate: <?= $sum ?></h3>
        <?php foreach ($data as $r): ?>

            <h3>
                Ricevuta numero <?= ($r->numero) ?>
            </h3>
            <p class='text-right'>
                emessa in data<?= ($r->dataemissione) ?>
            </p>
            <p>
                Dati di fatturazione <?= ($r->clienti_id) ? $r->clienti->nome : '' ?>
            </p>
            <div class='panel'>
                Descrizione 
                <div class='panel-body'>
                    <p><?= ($r->descrizione) ?></p>
                    <p>Costo: <?= ($r->importo) ?></p>
                </div>

            </div>
            <div class='panel'>
                Informazioni sul cliente <?= ($r->clienti_id) ? $r->clienti->nome : '' ?>
                <div class='panel-body'>
                    <p>Email<?= ($r->clienti_id) ? $r->clienti->email : '' ?></p>
                    <p>Telefono <?= ($r->clienti_id) ? $r->clienti->telefono : '' ?></p>
                    <p>Indirizzo <?= ($r->clienti_id) ? $r->clienti->residenza : '' ?></p>
                </div>
                <a href='?p=ricevuta2&id=<?= $r['id'] ?>'>
                    Stampa
                </a>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>




</div>