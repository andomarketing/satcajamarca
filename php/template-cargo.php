
<div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">
    
    <span> <?php echo $declaracionJurada ?></span>
    <span> <?php echo $codBarra ?></span>
    <span> <?php echo $emision ?></span>

    <table class="pre1-table">
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left"><span class="white-text">Código Contribuyente&nbsp&nbsp:</span> <?= $codigoContribuyente ?></td>
            <td class="pre1-td pre1-td-rigth" style="padding-left: 4.5mm;"><span class="white-text">DNI/RUC&nbsp&nbsp:</span> <?= $dni ?></td>
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">Nombre/Razón Social&nbsp&nbsp:</span> <?= $nombresYApellidos ?></td>
        </tr>
    </table>
    <table class="pre2-table">
        <tr class="pre2-tr">
            <td class="pre2-td pre2-td-left" colspan="2"><span class="white-text">Tipo de Contribuyente&nbsp&nbsp:</span> <?= $tipoContribuyente ?></td>
        </tr>
        <tr class="pre2-tr">
            <td class="pre2-td pre2-td-left" colspan="2" style="position: relative;"><span class="white-text">Domicilio Fiscal&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</span><span style="font-size: 6pt; position: absolute; width: 70%; top: -0.5mm; rigth: 2mm"> <?= $domicilioFiscal ?> </span></td>
        </tr>
    </table>
    <table class="pre3-table">
        <tr class="pre3-tr">
            <td class="pre3-td pre3-td-left"><span class="white-text">Referencia&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</span> <?= $referencia ?></td>
            <td class="pre3-td pre3-td-rigth"><span class="white-text">Mz/Ubicación&nbsp&nbsp:</span> <?= $mzUbicacion ?> </td>
        </tr>
    </table>
</div>
