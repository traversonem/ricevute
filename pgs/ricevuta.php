
<?php
$msg = '';
$tbl = 'ricliente';
$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
$record = (empty($_REQUEST['id'])) ? R::dispense($tbl) : R::load($tbl, intval($_REQUEST['id']));

//	if (!empty($_POST['id'])) :
//			foreach ($_POST as $key=>$value){
//				$record[$key]=$value;
//			}
//		try {
//			R::store($record);
//			$msg='Dati salvati correttamente ('.json_encode($record).') ';
//		} catch (RedBeanPHP\RedException\SQL $e) {
//			$msg=$e->getMessage();
//		}
//	endif;	
//	
//	if (!empty($_REQUEST['del'])) : 
//		$record=R::load($tbl, intval($_REQUEST['del']));
//		try{
//			R::trash($record);
//		} catch (RedBeanPHP\RedException\SQL $e) {
//			$msg=$e->getMessage();
//		}
//	endif;

$data = R::findAll($tbl, 'ORDER by id ASC LIMIT 999');
$clienti = R::findAll('clienti');
//$new=!empty($_REQUEST['create']);
//foreach ($clienti as $opt){if ($opt->id == $record->clienti_id){$clienti=$opt;}}
if (!empty($_POST['clienti_id'])) :
    foreach ($clienti as $str){if ($str->id == $record->clienti_id){$record=$str;}}

endif;

?>

<h3>
    <a href='index.php'>
        Torna alla Home page
    </a>

</h3>
<div class='container'>
    <?php if ($id) : ?>
        <a href='?p=ricevuta'>Elenco dettagliato stampabile</a>
        <h1> Ricevuta</h1>
        <?php echo ($record); ?>
    <?php else: ?>
        <a href="?p=ricevute">Elenco modificabile</a>
        <h1>ELENCO DETTAGLIATO</h1>
        <h3>Cerca</h3>
        <form method="post" action="?p=ricevuta">
            <select name="clienti_id">
                <?php foreach ($clienti as $str) : ?>

                    <option value="<?= $str->id ?>" <?= ($str->id == $clienti->clienti_id) ? 'selected' : '' ?> >
                        <?= $str->nome ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" tabindex="-1">
                Salva
            </button>
        </form>
        <?php foreach ($data as $r): ?>
            <h3>
                Ricevuta numero <?= ($r->numero) ?>
            </h3>
            <p class='text-right'>
                emessa in data<?= ($r->data) ?>
            </p>
            <p>
                Dati di fatturazione <?= ($r->nome) ?>
            </p>
            <div class='panel'>
                Descrizione 
                <div class='panel-body'>
                    <p><?= ($r->descrizione) ?></p>
                    <p>Costo: <?= ($r->importo) ?></p>
                </div>

            </div>
            <div class='panel'>
                Informazioni sul cliente <?= ($r->nome) ?>
                <div class='panel-body'>
                    <p>Email<?= ($r->email) ?></p>
                    <p>Telefono <?= ($r->telefono) ?></p>
                    <p>Indirizzo <?= ($r->residenza) ?></p>
                </div>

            </div>
            <a href='?p=ricevuta&id=<?= $r['id'] ?>'>
                Stampa
            </a>

        <?php endforeach; ?>

    <?php endif; ?>




</div>