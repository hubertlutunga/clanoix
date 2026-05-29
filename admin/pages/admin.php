<?php


	$stmtss = $pdo->prepare("SELECT * FROM is_users WHERE phone = ?");
	$stmtss->execute([$_SESSION['user_phone']]);
	$datasession = $stmtss->fetch();


	if (!isset($_SESSION['user_phone'])) {
		header("Location: index.php?page=logout"); // Rediriger vers users.php si déjà connecté
		exit();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/* ================= VISITEURS ================= */
    
    // Total visiteurs
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM visiteurs");
    $totalVisitors = $stmt->fetch()['total'] ?? 0;
    
    // Aujourd’hui
    $stmt = $pdo->query("
    SELECT COUNT(*) as total 
    FROM visiteurs 
    WHERE DATE(date_visite) = CURDATE()
    ");
    $todayVisitors = $stmt->fetch()['total'] ?? 0;
    
    // Top pays
    $stmt = $pdo->query("
    SELECT pays, COUNT(*) as total 
    FROM visiteurs 
    GROUP BY pays 
    ORDER BY total DESC 
    LIMIT 5
    ");
    $topPays = $stmt->fetchAll();
    
    // Top villes
    $stmt = $pdo->query("
    SELECT ville, COUNT(*) as total 
    FROM visiteurs 
    WHERE ville != '' 
    GROUP BY ville 
    ORDER BY total DESC 
    LIMIT 5
    ");
    $topVilles = $stmt->fetchAll();









/* ================= SOURCES TRAFIC ================= */
$stmt = $pdo->query("
SELECT 
    CASE 
        WHEN referer LIKE '%facebook%' THEN 'Facebook'
        WHEN referer LIKE '%tiktok%' THEN 'TikTok'
        WHEN referer LIKE '%google%' THEN 'Google'
        WHEN referer = '' OR referer IS NULL THEN 'Direct'
        ELSE 'Autres'
    END as source,
    COUNT(*) as total
FROM visiteurs
GROUP BY source
ORDER BY total DESC
LIMIT 5
");
$topSources = $stmt->fetchAll();


/* ================= PAGES VISITÉES ================= */
$stmt = $pdo->query("
SELECT page, COUNT(*) as total 
FROM visiteurs
GROUP BY page
ORDER BY total DESC
LIMIT 5
");
$topPages = $stmt->fetchAll();






?>

<style>
    .btn-note{
    background:#c82127;
    color:#fff;
    border:none;
    padding:8px 14px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:0.2s;
}

.btn-note:hover{
    background:#a61b20;
}


.highlight{
    background:linear-gradient(135deg, #c82127, #e33a3f);
    color:#fff;
}

.highlight .stat-label,
.highlight .stat-note{
    color:rgba(255,255,255,0.85);
}

.stat-card{
    position:relative;
    overflow:hidden;
}

.stat-card::after{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    background:rgba(255,255,255,0.05);
    border-radius:50%;
    top:-40px;
    right:-40px;
}
</style>

<header class="hero">
    <div class="container hero-top">
        <div class="brand">
            
            <div class="brand-mark">
              <img src="../images/logo_clanoix.png" alt="CLANOIX">
            </div>
            
            <div>
                <h1>Administration des commandes</h1>
                <p>CLANOIX — tableau de suivi des lecteurs</p>
            </div>
        </div>

        <div class="hero-right">

        
            <div style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
                <a href="index.php?page=accueil" class="btn">Voir le site</a>
        
                <a href="index.php?page=logout" class="logout-btn" title="Déconnexion">
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
                <div class="stat-note">Demandes enregistrées</div>
            </div>
        
            <div class="card stat-card highlight">
                <div class="stat-label">Total exemplaires</div>
                <div class="stat-value"><?= $totalQte ?></div>
                <div class="stat-note">Livres commandés</div>
            </div>
        
            <div class="card stat-card">
                <div class="stat-label">Aujourd’hui</div>
                <div class="stat-value"><?= $todayCount ?></div>
                <div class="stat-note">Nouvelles commandes</div>
            </div>
        
            <div class="card stat-card">
                <div class="stat-label">Cette semaine</div>
                <div class="stat-value"><?= $weekCount ?></div>
                <div class="stat-note">Activité récente</div>
            </div>
         

<!--visiteur-->

        <div class="card stat-card">
            <div class="stat-label">Visiteurs total</div>
            <div class="stat-value"><?= $totalVisitors ?></div>
            <div class="stat-note">Toutes les visites</div>
        </div>
        
        <div class="card stat-card highlight">
            <div class="stat-label">Visites aujourd’hui</div>
            <div class="stat-value"><?= $todayVisitors ?></div>
            <div class="stat-note">Trafic du jour</div>
        </div>
        
        
        <div class="card stat-card">
            <div class="stat-label">Source principale</div>
            <div class="stat-value">
                <?= !empty($topSources) ? $topSources[0]['source'] : '-' ?>
            </div>
            <div class="stat-note">Canal dominant</div>
        </div>
        
        <div class="card stat-card">
            <div class="stat-label">Page la + visitée</div>
            <div class="stat-value">
                <?= !empty($topPages) ? $topPages[0]['page'] : '-' ?>
            </div>
            <div class="stat-note">Contenu le plus vu</div>
        </div>



        </div>
        
        
        
        <?php 
            $objectif = 1000;
            $progress = min(100, ($totalQte / $objectif) * 100);
        ?>
        
        <div class="card" style="padding:20px;margin-bottom:20px;">
            
            <div style="font-weight:600;margin-bottom:10px;">
                Progression des commandes
            </div>
        
            <div style="background:#eee;height:10px;border-radius:10px;overflow:hidden;">
                <div style="
                    width:<?= $progress ?>%;
                    background:#c82127;
                    height:100%;
                    transition:0.5s;
                "></div>
            </div>
        
            <div style="margin-top:10px;color:#777;font-size:13px;">
                <?= number_format($totalQte) ?> / <?= $objectif ?> exemplaires
            </div>
        
        </div>

 
        



        
        
        <div class="card" style="padding:20px;margin-bottom:20px;">
            <h3 style="margin-bottom:15px;">🌍 Origine des visiteurs</h3>
        
            <div style="display:flex; gap:40px; flex-wrap:wrap;">
        
                <!-- PAYS -->
                <div style="flex:1;">
                    <strong>Top pays</strong><br><br>
                    <?php foreach($topPays as $row): ?>
                        <div style="margin-bottom:6px;">
                            <?= htmlspecialchars($row['pays'] ?: 'Inconnu') ?> 
                            — <strong><?= $row['total'] ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
        
                <!-- VILLES -->
                <div style="flex:1;">
                    <strong>Top villes</strong><br><br>
                    <?php foreach($topVilles as $row): ?>
                        <div style="margin-bottom:6px;">
                            <?= htmlspecialchars($row['ville']) ?> 
                            — <strong><?= $row['total'] ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
        
            </div>
        </div>





<!--
<div class="card" style="padding:20px;margin-bottom:20px;">
    <h3 style="margin-bottom:15px;">📊 Analyse du trafic</h3>

    <div style="display:flex; gap:40px; flex-wrap:wrap;">
 
        <div style="flex:1;">
            <strong>Sources de trafic</strong><br><br>
            <?php  foreach($topSources as $row): ?>
                <div style="margin-bottom:6px;">
                    <?= htmlspecialchars($row['source']) ?> 
                    — <strong><?= $row['total'] ?></strong>
                </div>
            <?php endforeach; ?>
        </div>
 
        <div style="flex:1;">
            <strong>Pages les plus visitées</strong><br><br>
            <?php foreach($topPages as $row): ?>
                <div style="margin-bottom:6px;">
                    <?= htmlspecialchars($row['page']) ?> 
                    — <strong><?= $row['total'] ?></strong>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

-->




   <!--     
        <div class="card" style="padding:20px;margin-bottom:20px;">
            <h3 style="margin-bottom:20px;">Évolution des commandes</h3>
        
            <canvas id="chart"></canvas>
        </div>
        

<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Commandes',
            data: <?= json_encode($values) ?>,
            borderColor: '#c82127',
            backgroundColor: 'rgba(200,33,39,0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#c82127'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

-->


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
                                    <div class="name"><?= htmlspecialchars(($row['prenom'] ?? '') . ' ' . ($row['nom'] ?? '')) ?></div>
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
                                        <button 
                                            class="btn-note"
                                            data-note="<?= htmlspecialchars($row['note'], ENT_QUOTES, 'UTF-8') ?>">
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
document.addEventListener('DOMContentLoaded', function(){

    document.querySelectorAll('.btn-note').forEach(button => {

        button.addEventListener('click', function(){

            let note = this.getAttribute('data-note') || '';

            // Sécurité + format
            note = note.replace(/\n/g, '<br>');

            Swal.fire({
                title: 'Note du client',
                html: '<div style="text-align:left; line-height:1.7;">' + note + '</div>',
                confirmButtonColor: '#c82127',
                width: 500
            });

        });

    });

});
</script>
