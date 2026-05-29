<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$configPath = dirname(__DIR__) . '/config.php';
$config = file_exists($configPath) ? require $configPath : [];
$db = $config['db'] ?? [];

try {
    $pdo = new PDO(
        $db['dsn'] ?? getenv('CLANOIX_DB_DSN'),
        $db['user'] ?? getenv('CLANOIX_DB_USER'),
        $db['password'] ?? getenv('CLANOIX_DB_PASSWORD')
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur DB : " . $e->getMessage());
}


error_reporting(E_ALL); ini_set("display_errors", 1);




$page = htmlentities($_GET['page']);
$pages = scandir('pages');

if(!empty($page) && in_array($_GET['page'].".php",$pages)) {
  
    $content = 'pages/'.$_GET['page'].".php";
} 
   
   
 else{
  header("Location:index.php?page=admin");
}




$stmt = $pdo->query("SELECT * FROM precommandes ORDER BY date_enreg DESC");
$precommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = count($precommandes);
$totalNouveau = 0;
$totalAttente = 0;
$totalAutres = 0;

foreach ($precommandes as $item) {
    $statut = strtolower(trim($item['statut'] ?? ''));
    if ($statut === 'nouveau') {
        $totalNouveau++;
    } elseif ($statut === 'en_attente') {
        $totalAttente++;
    } else {
        $totalAutres++;
    }
}

function badgeClass(string $statut): string {
    $s = strtolower(trim($statut));
    return match ($s) {
        'nouveau' => 'badge blue',
        'en_attente' => 'badge orange',
        'contacte', 'contacté' => 'badge purple',
        'confirme', 'confirmé' => 'badge green',
        'livre', 'livré' => 'badge dark',
        default => 'badge gray',
    };
}
?>






<?php

// TOTAL QUANTITÉ
$totalQte = 0;

// AUJOURD'HUI
$todayCount = 0;

// CETTE SEMAINE
$weekCount = 0;

$today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('monday this week'));

foreach ($precommandes as $row) {

    $totalQte += (int)$row['qte'];

    $date = date('Y-m-d', strtotime($row['date_enreg']));

    if ($date === $today) {
        $todayCount++;
    }

    if ($date >= $weekStart) {
        $weekCount++;
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Commandes - CLANOIX</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="shortcut icon" href="../images/logo_clanoix_2.png" />

<link rel="stylesheet" href="css/style.css"/>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    
    
    
    
    
    
      <?php
        include($content);
      ?>
    
    
<script>
const searchInput = document.getElementById('searchInput');
const table = document.getElementById('precommandesTable');

if (searchInput && table) {
    searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}
</script>




</body>
</html>