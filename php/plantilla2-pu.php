<div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">
    <div style="position: relative; width: 100%;">
        <span style="position: absolute; top: -11mm; right: 44mm;"> <?= $contri["NroDeclaracionJurada"] ?> </span>
        <span style="position: absolute; top: -6.5mm; right: 15mm;"> <?= $contri["emision"] ?> </span>
    </div>

    <table class="pre1-table">
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text" style="margin-right: 2mm">CÓDIGO CONTRIBUYENTE: </span><?= $contri["persona_id"] ?></td>   
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text" style="margin-right: 2mm">NOMBRE: </span>  <?= $contri["apellidos_nombres"] ?> </td>   
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left"><span class="white-text"   style="margin-right: 2mm">CÓDIGO PREDIO: </span><?= $PU["predio_id"] ?></td>
            <td class="pre1-td pre1-td-rigth"><span class="white-text"  style="margin-right: 2mm">CÓDIGO CATASTRAL: </span><?= $PU["codigoCatastral"] ?></td>
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2" style="font-size: 5pt;"><span class="white-text" style="margin-right: 4mm">DIRECCIÓN DE PREDIO: </span><?= strtoupper( $PU["direccion_completa"]) ?></td>  
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text" style="margin-right: 2mm">LUGAR: </span><?= strtoupper( $PU["lugar"]) ?></td>    
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text" style="margin-right: 2mm">SECTOR: </span><?= strtoupper( $PU["sector"]) ?></td>   
        </tr>
    </table>

    <table class="pre2-table">
        <tr class="pre2-tr">
            <td class="pre2-td pre2-td-left"><span class="white-text">UBICACIÓN DEL PREDIO:</span> <?= $PU["ubicacion_predio"] ?> </td>
            <td class="pre2-td pre2-td-center"><span class="white-text">CONDICIÓN DE PROPIEDAD:</span> <?= $PU["condicion_propiedad"] ?></td>
            <td class="pre2-td pre2-td-rigth"><span class="white-text">% DE PARTICIPACIÓN:</span> <?= $PU["porc_paticipacion"] ?></td>
        </tr>
    </table>

    <table class="pre4-table">
        <tr class="pre4-tr">
            <td class="pre4-td pre4-td-left"><span class="white-text" style="margin-right: 3mm">AREA DEL TERRENO M2:</span> <span style="font-size: 6pt"><?= number_format( $PU["area_terreno"], 2, ',', '.') ?></span> </td>
            <td class="pre4-td pre4-td-center"><span class="white-text" style="margin-right: 3mm">VALOR ARANCELARIO:</span> <span style="font-size: 6pt"><?= number_format( $PU["arancel"], 2, ',', '.') ?></span> </td>
            <td class="pre4-td pre4-td-rigth"><span class="white-text" style="margin-right: 5mm">VALOR TERNARIO M2:</span>  <span style="font-size: 6pt"><?= number_format( $PU["valor_terreno"], 2, ',', '.') ?></span> </td>
        </tr>
    </table>
    
    <table class="const-table">
        <tr style="height: 23mm">
            <td style="width: 2.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">TN</span></td>
            <td style="width: 5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">TN</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">NN</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 7mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 6mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 10mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text"></span></td>
            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 8.8mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 12.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
            <td style="width: 18mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text"></span></td>
        </tr>
        <?php foreach ($constru as $construccion): ?>
            <!-- height: 27.5mm -->
            <tr style="height: 9.1666mm">
                <td><span class="horizontal-text"  style="padding-right: 0.5mm"> <?php echo $construccion["item"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["TipoNivel"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["nro_nivel"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["seccion"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["anno_construccion"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["material_predominante"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["estado_concervacion"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["muros"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["techo"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["pisos"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["puertas"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["revestimientos"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["bannos"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["electricos"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["valor_unitario"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["valor_incremento"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["porc_depreciacion"] ?></span></td>
                <td><span class="horizontal-text"> <?php echo $construccion["valor_depreciacion"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["valor_unitario_depre"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["valor_unitario_depre"] ?></span></td>
                <td><span class="vertical-text"> <?php echo $construccion["valor_area_construida"] ?></span></td>
                <td><span class="vertical-text" style="border: none;"> <?php echo $construccion["valor_construccion"] ?></span></td>
            </tr>
        <?php endforeach; ?>
        <tr style="height: 5mm; vertical-align: bottom; " >
            <td colspan="16">
            </td>
            <td colspan="2">
            </td>
            <td colspan="2"> <span style="font-size: 6pt; font-weight: bold;"> <?= number_format($PU["area_construida"], 2, ',', '.') ?> </span>
            </td>
            <td></td>
            <td> <span style="font-size: 6pt; font-weight: bold;"> <?= number_format($PU["valor_construccion"], 2, ',', '.') ?> </span></td>
        </tr>
    </table>

    <table class="comp-table" style="height: 21mm;">
        <tr style="height: 6mm">
            <td style="width: 8mm; font-size: 3pt"></td>
            <td style="width: 8mm; font-size: 3pt"></td>
            <td style="width: 31mm; font-size: 3pt"></td>
            <td style="width: 16mm; font-size: 3pt"></td>
            <td style="width: 10mm; font-size: 3pt"></td>
            <td style="width: 9mm; font-size: 3pt"></td>
            <td style="width: 10mm; font-size: 3pt"></td>
            <td style="width: 13mm; font-size: 3pt"></td>
            <td style="width: 11mm; font-size: 3pt"></td>
            <td style="width: 11mm; font-size: 3pt"></td>
        </tr>
        <?php foreach ($insta as $instalacion): ?>
            <tr style="height: 3mm">
                <td> <?php echo $instalacion["item"] ?></td>
                <td> <?php echo $instalacion["tipo_obra_id"] ?></td>
                <td> <?php echo $instalacion["descripcion"] ?></td>
                <td> <?php echo $instalacion["anno_instalacion"] ?></td>
                <td> <?php echo $instalacion["medida"] ?></td>
                <td> <?php echo $instalacion["unidad_medida"] ?></td>
                <td> <?php echo $instalacion["valor_unitario"] ?></td>
                <td> <?php echo $instalacion["valor_instalacion"] ?></td>
                <td> <?php echo $instalacion["factor_oficializacion"] ?></td>
                <td> <?php echo $instalacion["valor_total"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <table class="comp-table">
        <tr>
            <td style="width: 8mm; font-size: 3pt"></td>
            <td style="width: 8mm; font-size: 3pt"></td>
            <td style="width: 31mm; font-size: 3pt"></td>
            <td style="width: 16mm; font-size: 3pt"></td>
            <td style="width: 10mm; font-size: 3pt"></td>
            <td style="width: 9mm; font-size: 3pt"></td>
            <td style="width: 10mm; font-size: 3pt"></td>
            <td style="width: 13mm; font-size: 3pt"></td>
            <td style="width: 11mm; font-size: 3pt"></td>
            <td style="width: 11mm; font-size: 3pt"></td>
        </tr>
        <!-- DATOS DE INSTALACIONES -->
        <tr style="height: 2mm">
            <td colspan="10"></td>
        </tr>
        <tr style="height: 3mm">
            <td colspan="10"></td>
        </tr>
        <tr style="height: 0.2mm">
            <td colspan="10"></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm;"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt; font-weight: bold;"><?= number_format($PU["valor_construccion"], 2, ',', '.') ?></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt; font-weight: bold;"><?= number_format($PU["valor_terreno"], 2, ',', '.') ?></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt; font-weight: bold;"><?= number_format($PU["valor_instalacion"], 2, ',', '.') ?></td>
        </tr>
        <tr style="height: 3.3mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt; font-weight: bold;"><?= number_format($PU["base_imponible"], 2, ',', '.') ?></td>
        </tr>
    </table>
</div>