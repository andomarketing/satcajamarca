<div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">

    <div style="position: relative; width: 100%;">
            <span style="position: absolute; top: -11mm; right: 44mm;"> <?= $contri["NroDeclaracionJurada"] ?> </span>
            <span style="position: absolute; top: -6.5mm; right: 15mm;"> <?= $contri["emision"]  ?> </span>
    </div>

    <!-- DATOS DEL PREDIO -->
    <table class="pre1-table">
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">CÓDIGO CONTRIBUYENTE: </span> <?= $contri["persona_id"] ?></td>
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">NOMBRE: </span> <?= $contri["apellidos_nombres"] ?></td>
        </tr> 
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left"><span class="white-text">CÓDIGO PREDIO: </span> <?php echo $PR["predio_id"]; ?></td>
            <td class="pre1-td pre1-td-rigth"><span class="white-text">CÓDIGO CATASTRAL: </span> <?php echo $PR["codigoCatastral"]; ?></td>
        </tr>
        <tr class="pre1-tr">
            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">DIRECCIÓN DE PREDIO:</span> <span style="font-size: 5pt;"> <?php echo strtoupper( $PR["direccion_completa"] ); ?></span></td>
        </tr>
    </table>
    <!-- DATOS DEL PREDIO -->

    <!-- DESCRIPCION DE PROPIEDAD -->
    <table class="pre2-table">
        <tr class="pre2-tr">
            <td class="pre2-td pre2-td-left"><span class="white-text">COND. PROPIEDAD: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["condicion_propiedad"]; ?></td>
            <td class="pre2-td pre2-td-center"><span class="white-text">% DE PARTICIPACIÓN: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["porc_propiedad"]; ?></td>
            <td class="pre2-td pre2-td-rigth"><span class="white-text">TIPO DE TIERRA: </span> <span style="position: absolute;right: 10px;width: 53%;font-size: 4.5pt;top: 2.5mm;"> <?php echo $PR["tipo_tierra"]; ?></span></td>
        </tr>
        <tr class="pre2-tr">
            <td class="pre2-td pre2-td-left"><span class="white-text">ALTITUD: </span> <?php echo $PR["altitud"]; ?></td>
            <td class="pre2-td pre2-td-center"><span class="white-text">CATEGORIA: </span> <?php echo $PR["categoria_rustico"]; ?></td>
            <td class="pre2-td pre2-td-rigth"><span class="white-text">USO: </span> <?php echo $PR["uso"]; ?></td>
        </tr>
    </table>
    <!-- DESCRIPCION DE PROPIEDAD -->

    <!-- TITULO X -->
    <table class="pre3-table">
        <tr>
            <td class="pre3-td">
                <span class="white-text">CONDICIÓN DE PROPIEDAD:</span>
            </td>
        </tr>
    </table>
    <!-- TITULO X -->    

    <!-- DETERMINACION DEL VALOR DEL PRECIO -->
    <table class="pre4-table">
        <tr class="pre4-tr">
            <td class="pre4-td pre4-td-left"><span class="white-text">AREA DEL TERRENO HA: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 9mm"> <?php echo $PR["area"] ?> </span> </td>
            <td class="pre4-td pre4-td-center"><span class="white-text">VALOR ARANCELARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 8mm"> <?php echo $PR["arancel"] ?> </span> </td>
            <td class="pre4-td pre4-td-rigth"><span class="white-text">VALOR TERNARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 2.5mm"> <?php echo $PR["valor_terreno"] ?> </span> </td>
        </tr>
    </table>
    <!-- DETERMINACION DEL VALOR DEL PRECIO -->

    <!-- CONSTRUCCIONES -->
    <table class="const-table">
        <tr style="height: 23mm">
            <td style="width: 2.5mm; vertical-align: bottom; padding-bottom: 2mm;"></td>
            <td style="width: 5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">TN</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">NN</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">SECCIÓN</span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ANTIGUEDAD</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">MP</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">EDC</span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">MC</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">T</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">P</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">PV</span></td>
            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">RV</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">B</span></td>
            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">IE</span></td>
            <td style="width: 7mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUPM2</span></td>
            <td style="width: 6mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ID5%</span></td>
            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">%</span></td>
            <td style="width: 10mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">VALOR</span></td>
            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUD</span></td>
            <td style="width: 8.8mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁC</span></td>
            <td style="width: 12.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁCM2</span></td>
            <td style="width: 18mm; vertical-align: bottom; padding-bottom: 2mm;border-bottom: 0.01mm solid blue"><span class="vertical-text white-text">VDLC</span></td>
        </tr>
        <?php
        foreach ($constru as $construccion ):
        ?>
        <!-- height: 27.5mm -->
        <tr style="height: 9.1666mm">
            <td><span class="horizontal-text"> <?php echo $construccion["item"] ?></span></td>
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
            <td><span class="vertical-text"> <?php echo $construccion["valor_construccion"] ?></span></td>
        </tr>
        <?php endforeach; ?>
        <!-- TOTALES -->
        <tr style="height: 5mm">
            <td colspan="16">
            </td>
            <td colspan="2">
            </td>
            <td colspan="2" style="font-size: 6pt;"> <?php echo $PR["area_construida"] ?>
            </td>
            <td></td>
            <td style="font-size: 6pt;"> <?php echo $PR["valor_construccion"] ?></td>
        </tr>
        <!-- TOTALES -->
    </table>
    <!-- CONSTRUCCIONES -->

    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->
    <table class="comp-table" style="height: 21mm">
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
        <!-- DATOS DE INSTALACIONES -->
        <?php foreach ($insta as $instalacion): ?>
            <!-- 15mm -->
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
        <!-- DATOS DE INSTALACIONES -->
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
            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_construccion"] ?></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_terreno"] ?></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_instalacion"] ?></td>
        </tr>
        <tr style="height: 3.3mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
            <td colspan="2" style="font-size: 6pt"><?php echo $PR["base_imponible"] ?></td>
        </tr>
    </table>
    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->
</div> 



