<?php

    function tablePrint($column_header,$rows){
        if(!is_array($column_header) || !is_array($rows)){
            throw new Exception("Invalid argument type");
        }
        $formated_column = '<tr>';
        foreach ($column_header as $h){
            $formated_column .= "<th scope='col'>{$h}</th>";
        }
        $formated_column.='</tr>';
        
        
        $formated_row='';
        foreach ($rows as $row){
            $formated_row .= "<tr>";
                foreach ($row as $r){
                    $formated_row .= "<td>{$r}</td>";
                }
            $formated_row .= "</tr>";
        }
        $tableHtml = "<table class='table table-striped'>
                    <thead>
                        {$formated_column}
                    </thead>
                    <tbody>
                        {$formated_row}
                    </tbody></table>";

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($tableHtml,LIBXML_HTML_NOIMPLIED);
        $dom->formatOutput = true;

        return $dom->saveHTML();
    }
?>