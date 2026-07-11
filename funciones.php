<?php
function fecha($fecha)
{
    switch($fecha[5].$fecha[6])
    {
        case '01': $mes='Enero'; break;
        case '02': $mes='Febrero'; break;
        case '03': $mes='Marzo'; break;
        case '04': $mes='Abril'; break;
        case '05': $mes='Mayo'; break;
        case '06': $mes='Junio'; break;
        case '07': $mes='Julio'; break;
        case '08': $mes='Agosto'; break;
        case '09': $mes='Septiembre'; break;
        case '10': $mes='Octubre'; break;
        case '11': $mes='Noviembre'; break;
        case '12': $mes='Diciembre'; break;
    }

    return $fecha[8].$fecha[9].' - '.$mes.' - '.$fecha[0].$fecha[1].$fecha[2].$fecha[3];
}

function fecha_evento($fecha)
{
    switch($fecha[5].$fecha[6])
    {
        case '01': $mes='Enero'; break;
        case '02': $mes='Febrero'; break;
        case '03': $mes='Marzo'; break;
        case '04': $mes='Abril'; break;
        case '05': $mes='Mayo'; break;
        case '06': $mes='Junio'; break;
        case '07': $mes='Julio'; break;
        case '08': $mes='Agosto'; break;
        case '09': $mes='Septiembre'; break;
        case '10': $mes='Octubre'; break;
        case '11': $mes='Noviembre'; break;
        case '12': $mes='Diciembre'; break;
    }

    switch(date("N", strtotime($fecha)))
    {
        case 1: $dia='Lunes'; break;
        case 2: $dia='Martes'; break;
        case 3: $dia='Miercoles'; break;
        case 4: $dia='Jueves'; break;
        case 5: $dia='Viernes'; break;
        case 6: $dia='Sabado'; break;
        case 7: $dia='Domingo'; break;
    }

    return $dia.' '.$fecha[8].$fecha[9].' de '.$mes.' de '.$fecha[0].$fecha[1].$fecha[2].$fecha[3].' '.$fecha[11].$fecha[12].$fecha[13].$fecha[14].$fecha[15].' Hrs.';
}

function hora_evento($fecha)
{
    return $fecha[11].$fecha[12].$fecha[13].$fecha[14].$fecha[15].' Hrs.';
}
?>