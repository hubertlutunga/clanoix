<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$configPath = __DIR__ . '/config.php';
$config = file_exists($configPath) ? require $configPath : [];
$db = $config['db'] ?? [];
$mailConfig = $config['mail'] ?? [];

try {
    $pdo = new PDO(
    $db['dsn'] ?? getenv('CLANOIX_DB_DSN'),
    $db['user'] ?? getenv('CLANOIX_DB_USER'),
    $db['password'] ?? getenv('CLANOIX_DB_PASSWORD')
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur DB : ' . $e->getMessage());
}

$page = isset($_GET['page']) ? basename($_GET['page']) : 'accueil';
$pages = scandir('pages');

if (!empty($page) && in_array($page . ".php", $pages)) {
    $content = 'pages/' . $page . ".php";
} else {
    header("Location: ?page=accueil");
    exit;
}

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* =========================
   TRAITEMENT FORMULAIRE
========================= */
if (isset($_POST['submitpc'])) {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $qte       = trim($_POST['qty'] ?? '');
    $adresse   = trim($_POST['city'] ?? '');
    $note      = trim($_POST['message'] ?? '');

    $date_enreg = date('Y-m-d H:i:s');
    $statut = 'en_attente';

    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($qte) || empty($adresse)) {
      header("Location: ?page=accueil&ok=3#commande");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location: ?page=accueil&ok=4#commande");
        exit;
    }

    try {
        $sql = "INSERT INTO precommandes (prenom, nom, phone, email, qte, adresse, note, date_enreg, statut)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $phone, $email, $qte, $adresse, $note, $date_enreg, $statut]);

        $prenom = $firstName;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
          $mail->Host       = $mailConfig['host'] ?? getenv('CLANOIX_SMTP_HOST');
            $mail->SMTPAuth   = true;
          $mail->Username   = $mailConfig['username'] ?? getenv('CLANOIX_SMTP_USER');
          $mail->Password   = $mailConfig['password'] ?? getenv('CLANOIX_SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port       = (int)($mailConfig['port'] ?? getenv('CLANOIX_SMTP_PORT') ?: 465);
            $mail->CharSet    = 'UTF-8';

          $fromEmail = $mailConfig['from_email'] ?? getenv('CLANOIX_MAIL_FROM') ?: 'contact@clanoix.com';
          $fromName = $mailConfig['from_name'] ?? getenv('CLANOIX_MAIL_FROM_NAME') ?: 'CLANOIX';

          $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($email, $firstName . ' ' . $lastName);
          $mail->addReplyTo($fromEmail, $fromName);

            $mail->isHTML(true);
            $mail->Subject = "Votre commande est confirmée – Naviguer dans la prise de poste";

            $mail->Body = "
            <div style='font-family:Arial,sans-serif;padding:20px;color:#333;line-height:1.7;'>
                <p>Bonjour <strong>" . htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') . "</strong>,</p>

                <p>
                Nous vous remercions pour votre commande du livre :
                    <strong>Naviguer dans la prise de poste</strong> de
                <strong>Aurélien NGANDZIAMI</strong>. Votre demande a bien été enregistrée par la maison d’édition CLANOIX.
                </p>

                <p>
                Prix public : <strong>22,87 € (15 000 XAF)</strong>.<br>
                Quantité commandée : <strong>" . htmlspecialchars($qte, ENT_QUOTES, 'UTF-8') . "</strong> exemplaire(s).
                </p>

                <p>
                Notre équipe vous contactera prochainement afin de confirmer les modalités de paiement,
                de retrait ou de livraison selon votre ville.
                </p>

                <p>
                Merci de votre confiance et excellente lecture.
                </p>

                <p>
                Cordialement,<br>
                <strong>CLANOIX — Maison d’édition</strong>
                </p>

              <p><img src='https://clanoix.com/images/logo_clanoix.png' width='220' alt='CLANOIX'></p>
            </div>";

            $mail->send();
    ?>
           <script>
            window.location.href = "?page=accueil&ok=1#commande";
          </script>
    <?php

        } catch (Exception $e) { 

        ?>
              <script>
            window.location.href = "?page=accueil&ok=2#commande";
              </script>
        <?php
        }

    } catch (PDOException $e) { 
        ?>
              <script>
            window.location.href = "?page=accueil&ok=0#commande";
              </script>
        <?php
        
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CLANOIX — Maison d’édition | Naviguer dans la prise de poste</title>
  <meta name="description" content="CLANOIX, maison d’édition, présente le livre Naviguer dans la prise de poste d’Aurélien NGANDZIAMI, disponible à la commande." />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="images/logo_clanoix_2.png" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include($content); ?>

<?php if (isset($_GET['ok'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ok = "<?= htmlspecialchars($_GET['ok'], ENT_QUOTES, 'UTF-8') ?>";

  if (ok === "1") {
    Swal.fire({
      icon: 'success',
      title: 'Commande enregistrée',
      text: 'Votre commande a bien été prise en compte. Un email de confirmation vous a été envoyé.',
      confirmButtonColor: '#c82127'
    });
  } else if (ok === "2") {
    Swal.fire({
      icon: 'warning',
      title: 'Commande enregistrée',
      text: "La commande a été enregistrée, mais l'email n'a pas pu être envoyé.",
      confirmButtonColor: '#c82127'
    });
  } else if (ok === "0") {
    Swal.fire({
      icon: 'error',
      title: 'Erreur',
      text: "Une erreur est survenue lors de l'enregistrement en base.",
      confirmButtonColor: '#c82127'
    });
  } else if (ok === "3") {
    Swal.fire({
      icon: 'error',
      title: 'Champs requis',
      text: 'Veuillez remplir tous les champs obligatoires.',
      confirmButtonColor: '#c82127'
    });
  } else if (ok === "4") {
    Swal.fire({
      icon: 'error',
      title: 'Email invalide',
      text: 'Veuillez saisir une adresse email valide.',
      confirmButtonColor: '#c82127'
    });
  }
});
</script>
<?php endif; ?>

</body>
</html>