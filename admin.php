<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$configPath = __DIR__ . '/config.php';
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

<link rel="shortcut icon" href="images/logo_clanoix_2.png" />

<link rel="stylesheet" href="css/style.css"/>

</head>

<body>

<header class="hero">
    <div class="container hero-top">
        <div class="brand">
            
            <div class="brand-mark">
              <img src="images/logo_clanoix.png" alt="CLANOIX">
            </div>
            
            <div>
                <h1>Administration des commandes</h1>
                <p>CLANOIX — tableau de suivi des lecteurs</p>
            </div>
        </div>

        <div class="hero-right">

        
            <div style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
                <a href="index.php?page=accueil" class="btn">Voir le site</a>
        
                <a href="logout.php" class="logout-btn" title="Déconnexion">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            
             <br><br>
        
        </div>
        
    </div>
</header>

<main class="section">
    <div class="container">

        <div class="stats">
            <div class="card stat-card">
                <div class="stat-label">Total commandes</div>
                <div class="stat-value"><?= $total ?></div>
                <div class="stat-note">Toutes les demandes enregistrées</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">En attente</div>
                <div class="stat-value" style="color:#f59e0b;"><?= $totalAttente ?></div>
                <div class="stat-note">Commandes à traiter</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Nouveau</div>
                <div class="stat-value" style="color:#3b82f6;"><?= $totalNouveau ?></div>
                <div class="stat-note">Nouvelles entrées</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Autres statuts</div>
                <div class="stat-value" style="color:#8b5cf6;"><?= $totalAutres ?></div>
                <div class="stat-note">Contacté, confirmé, livré...</div>
            </div>
        </div>

        <div class="card">
            <div class="toolbar">
                <div class="toolbar-left">
                    <h2>Liste des commandes</h2>
                    <p>Consultez, filtrez et suivez les demandes des lecteurs.</p>
                </div>

                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Rechercher par nom, téléphone, email, ville...">
                </div>
            </div>

            <div class="table-wrap">
                <?php if (!empty($precommandes)): ?>
                <table id="precommandesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Contact</th>
                            <th>Quantité</th>
                            <th>Adresse</th>
                            <th>Note</th>
                            <th>Date</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($precommandes as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <div class="name"><?= htmlspecialchars($row['noms'] ?? '') ?></div>
                                    <div class="sub">ID: <?= (int)($row['cod_pc'] ?? 0) ?></div>
                                </td>

                                <td>
                                    <div><?= htmlspecialchars($row['phone'] ?? '') ?></div>
                                    <div class="sub"><?= htmlspecialchars($row['email'] ?? '') ?></div>
                                </td>

                                <td>
                                    <span class="qty"><?= htmlspecialchars($row['qte'] ?? '0') ?></span>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['adresse'] ?? '-') ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['note'])): ?>
                                        <button class="btn-note" onclick="showNote(`<?= htmlspecialchars(addslashes($row['note'])) ?>`)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    <?php else: ?>
                                        <span style="color:#aaa;">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                    $date = $row['date_enreg'] ?? '';
                                    echo $date ? date('d/m/Y H:i', strtotime($date)) : '-';
                                    ?>
                                </td>

                                 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="empty">
                        Aucune commande enregistrée pour le moment.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-note">
            Tableau d’administration — CLANOIX
        </div>
    </div>
</main>

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



<script>
function showNote(note){
    Swal.fire({
        title: 'Note client',
        html: '<div style="text-align:left">' + note.replace(/\n/g, "<br>") + '</div>',
        confirmButtonColor: '#c82127',
        width: 500
    });
}
</script>

</body>
</html>