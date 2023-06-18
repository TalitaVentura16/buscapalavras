<!DOCTYPE html>
<html>
<head>
    <title>Search CSV</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Search CSV</h1>
    <form method="GET">
        <label for="search">Search Frequency:</label>
        <input type="text" name="search" id="search" placeholder="Enter frequency">
        <input type="submit" value="Search">
    </form>

    <?php
    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        $results = [];
        
        $file = fopen('sked-a23.csv', 'r');
        
        if ($file) {
            $header = fgetcsv($file, 0, "\t");
            
            $frequencyColumnIndex = array_search('kHz:75', $header);
            
            while ($row = fgetcsv($file, 0, "\t")) {
                $frequency = $row[$frequencyColumnIndex];
                
                if (stripos($frequency, $search) !== false) {
                    $results[] = $row;
                }
            }
            
            fclose($file);
        }
        
        if (!empty($results)) {
            echo '<h2>Resultados para a frequência "'.$search.'":</h2>';
            
            echo '<table>';
            echo '<tr>';
            foreach ($header as $column) {
                echo '<th>'.$column.'</th>';
            }
            echo '</tr>';
            
            foreach ($results as $result) {
                echo '<tr>';
                foreach ($result as $value) {
                    echo '<td>'.$value.'</td>';
                }
                echo '</tr>';
            }
            
            echo '</table>';
        } else {
            echo 'Nenhum resultado encontrado para a frequência "'.$search.'".';
        }
    }
    ?>
</body>
</html>
