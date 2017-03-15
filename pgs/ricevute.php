<?php
$msg = '';
//$view = 'ricevuta';
$tbl = 'ricevute';
$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
$record = (empty($_REQUEST['id'])) ? R::dispense($tbl) : R::load($tbl, intval($_REQUEST['id']));
if (!empty($_POST['clienti_id'])) :
    foreach ($_POST as $key => $value) {
        $record[$key] = $value;
    }
    try {
        R::store($record);
        $msg = 'Dati salvati correttamente (' . json_encode($record) . ') ';
    } catch (RedBeanPHP\RedException\SQL $e) {
        $msg = $e->getMessage();
    }
endif;

if (!empty($_REQUEST['del'])) :
    $record = R::load($tbl, intval($_REQUEST['del']));
    try {
        R::trash($record);
    } catch (RedBeanPHP\RedException\SQL $e) {
        $msg = $e->getMessage();
    }
endif;

$data = R::findAll($tbl, 'ORDER by id ASC LIMIT 999');
$clienti = R::findAll('clienti');
$new = !empty($_REQUEST['create']);
?>

<h1>
    <a href="index.php">
        <?= ($id) ? ($new) ? 'Nuova ricevuta' : 'Ricevuta n. ' . $id : 'Ricevute'; ?>
    </a>
</h1>
<?php if ($id || $new) : ?>
    <form method="post" action="?p=<?= $tbl ?>">
        <?php if ($id) : ?>
            <input type="hidden" name="id" value="<?= $record->id ?>" />
        <?php endif; ?>

        <label for="numero">
            Numero
        </label>
        <input name="numero" maxlength="5" value="<?= $record->numero ?>" type="number">
        <label for="dataemissione">
            Data
        </label>
        <input name="dataemissione" max="<?= date("Y-m-d") ?>"  value="<?= date('Y-m-d', strtotime($record->dataemissione)) ?>" type="date" />

        <label for="clienti_id">
            Cliente
        </label>
        <select name="clienti_id">
            <option />
            <?php foreach ($clienti as $opt) : ?>
                <option value="<?= $opt->id ?>" <?= ($opt->id == $record->clienti_id) ? 'selected' : '' ?> >
                    <?= $opt->nome ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="descrizione">
            Descrizione
        </label>
        <input name="descrizione"  value="<?= $record->descrizione ?>" autofocus required  />			
        <label for="importo">
            Importo
        </label>			
        <input name="importo" value="<?= $record->importo ?>" type="number" step="any" />
        <button type="submit" tabindex="-1">
            Salva
        </button>

        <a href="?p=<?= $tbl ?>" >
            Elenco
        </a>			

        <a href="?p=<?= $tbl ?>&del=<?= $record['id'] ?>" tabindex="-1">
            Elimina
        </a>					
    </form>
<?php else : ?>
    <h3>
        <a href='?p=ricevuta2'>
            Elenco stampabile
        </a>
    </h3>

    <div class="tablecontainer">
        <table style="table-layout:fixed">
            <colgroup>
                <col style="width:150px" />
            </colgroup>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Ricevuta numero</th>
                    <th>Data</th>
                    <th>Descrizione</th>
                    <th>Importo</th>
                    <th style="width:60px;text-align:center">Modifica</th>
                    <th style="width:60px;text-align:center">Cancella</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $r) : ?>
                    <tr>
                        <td>
                            <?= ($r->clienti_id) ? $r->clienti->nome : '' ?>
                        </td>			
                        <td>
                            <?= ($r->numero) ?>
                        </td>			
                        <td>
                            <?= date('d/m/Y', strtotime($r->dataemissione)) ?>
                        </td>
                        <td>
                            <?= $r->descrizione ?>
                        </td>
                        <td style="text-align:right" >
                            <?=
                            (number_format($r->importo, 2, ',', '.')) . " Euro";
                            ?>
                        </td>			
                        <td style="text-align:center" >
                            <a href="?p=<?= $tbl ?>&id=<?= $r['id'] ?>">
                                Mod.
                            </a>
                        </td>
                        <td style="text-align:center" >
                            <a href="?p=<?= $tbl ?>&del=<?= $r['id'] ?>" tabindex="-1">
                                x
                            </a>
                        </td>
                        

                    </tr>	
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class='pull-right'>
                            totale: <?=$sum+= $r->importo;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <?=$sum?>
            </tbody>
        </table>
        <h4 class="msg">
            <?= $msg ?>
        </h4>	
    </div>
<?php endif; ?>
<a href="?p=<?= $tbl ?>&create=1">Inserisci nuovo</a>
<script>
    var chg = function (e) {
        console.log(e.name, e.value)
        document.forms.frm.elements[e.name].value = (e.value) ? e.value : null
    }
</script>