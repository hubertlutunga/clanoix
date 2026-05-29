 
<style>
:root{
    --primary:#c82127;
    --bg:#f7f8fc;
    --text:#1f2430;
    --muted:#6f7787;
    --line:#e8ebf3;
    --white:#ffffff;
    --shadow:0 10px 30px rgba(0,0,0,.08);
    --radius:22px;
}

*{box-sizing:border-box}

body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#fff5f5,#f7f8fc);
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
}

/* CARD */
.login-card{
    width:100%;
    max-width:420px;
    background:var(--white);
    border-radius:var(--radius);
    padding:40px 30px;
    box-shadow:var(--shadow);
    text-align:center;
}

/* LOGO */
.logo{
    margin-bottom:20px;
}

.logo img{
    width:150px;
}

/* TITRE */
h1{
    margin:10px 0 5px;
    font-size:24px;
}

.sub{
    color:var(--muted);
    font-size:14px;
    margin-bottom:30px;
}

/* FORM */
.form-group{
    text-align:left;
    margin-bottom:18px;
}

.form-group label{
    display:block;
    font-size:13px;
    margin-bottom:6px;
    font-weight:600;
}

.form-group input{
    width:100%;
    padding:14px;
    border-radius:12px;
    border:1px solid var(--line);
    font-size:14px;
    outline:none;
}

.form-group input:focus{
    border-color:#c82127;
    box-shadow:0 0 0 3px rgba(200,33,39,0.1);
}

/* BUTTON */
.btn-login{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:var(--primary);
    color:#fff;
    font-weight:700;
    cursor:pointer;
    transition:0.2s;
    font-size:15px;
}

.btn-login:hover{
    background:#a61b20;
}

/* FOOTER */
.footer{
    margin-top:20px;
    font-size:12px;
    color:var(--muted);
}
</style> 

<div class="login-card">

    <div class="logo">
        <img src="../images/logo_clanoix.png" alt="CLANOIX">
    </div>

    <h1>Connexion Admin</h1>
    <div class="sub">Accès sécurisé à la gestion des commandes</div>
    
    
    
    
    
<?php
    
    
    
    if (isset($_SESSION['user_phone'])) {

	$stmtss = $pdo->prepare("SELECT * FROM is_users WHERE phone = ?");
	$stmtss->execute([$_SESSION['user_phone']]);
	$datasession = $stmtss->fetch();

    if ($datasession['type_user'] == '1') {
        header("Location: index.php?page=admin"); 
    }
    exit();
    
    
    
    
    
}else {  
    

if (isset($_POST['submit_log'])) {
    
       
       // Récupérer les données du formulaire
        $identifiant = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
    
        // Préparer la requête pour vérifier si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT * FROM is_users WHERE email = ? OR phone = ?");
        $stmt->execute([$identifiant, $identifiant]);
        $user = $stmt->fetch();
    
        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie, stocker les informations utilisateur dans la session
           // $_SESSION['user_id'] = $user['cod_user'];
             
            $_SESSION['user_phone'] = $user['phone'];
            $_SESSION['user_email'] = $user['email']; 

            if ($user['type_user'] == '1') { 
                ?>
                
                
                 <script>
              window.location.href = "index.php?page=admin";
              </script>
              
              
              <?php
            }
             
            exit(); // Terminer le script après la redirection

        } else {
            echo "<span style='color:red;'>Identifiant ou mot de passe incorrect.</span>";
        }
 
        
}

}
    
    


 
?>





    <form method="POST" action="">
        
        <div class="form-group">
            <label>Identifiant</label>
            <input type="text" name="username" placeholder="Votre identifiant" required>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" name="submit_log" class="btn-login">
            Se connecter
        </button>

    </form>

    <div class="footer">
        © CLANOIX — Accès réservé
    </div>

</div>
 