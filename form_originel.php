<?php

  $mode = 'ajout';
  $id_update = null;
  require_once 'config/configoriginel.php';

  try {
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USER, MDP, $options);
  } catch (Exception $e) {
    echo $e->getMessage();

  }

  // PRESELECTION CHAMPS SUITE CLICK MODIFIER

  if(isset($_GET['id_edit']) && !empty($_GET['id_edit'])) {
    
    $id_update = htmlentities($_GET['id_edit']);
    $mode = 'edit';

    $reqById = $bdd->prepare("SELECT * FROM clients WHERE id=:id_update");
    $reqById->execute(array(
                          'id_update' => $id_update  
      ));

    $clientsById = $reqById->fetch();

  }
  // AJOUT CLIENTS

  if( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['cheveux']) && isset($_POST['produits'])) {

    $nom= htmlentities($_POST['nom']);
    $prenom = htmlentities($_POST['prenom']);
    $email = htmlentities($_POST['email']);
    $cheveux = htmlentities($_POST['cheveux']);
    $produits= htmlentities($_POST['produits']);

    if(isset($_POST['mode']) && $_POST['mode'] == 'ajout') {

      $reqInsert = $bdd->prepare("INSERT INTO clients (nom,prenom,email,cheveux,produits) VALUES (:nom, :prenom, :email, :cheveux, :produits)");
      $reqInsert->execute(array(
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'email' => $email,
                            'cheveux' => $cheveux,
                            'produits' => $produits
      ));
      header('location:index_originel.php');
    } //MODIFICATION CLIENTS
    elseif(isset($_POST['mode']) && $_POST['mode'] == 'edit') {

        $id_update = $_POST['id_edit'];

        $reqUpdate = $bdd->prepare("UPDATE clients SET nom=:nom, prenom=:prenom, email=:email, cheveux=:cheveux, produits=:produits WHERE id=:id_update");
        $reqUpdate->execute (array(
                                  'nom' => $nom,
                                  'prenom' => $prenom,
                                  'email' => $email,
                                  'cheveux' => $cheveux,
                                  'produits' => $produits,
                                  'id_update' => $id_update
            ));
    }
  } 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    

    <title>Formulaire - Produits Originel</title>
  </head>
  <body>
    <div class="container">

            <!-- DEBUT FORMULAIRE -->

            <?php include_once 'config/header_originel.php';?>
      
            <h1><?php echo $mode == 'ajout' ? 'Formulaire Ajout nouveau client' : 'Formulaire Modification clients' ;?></h1>
            <br>

            <form method="post" action="form_originel.php">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" name="id_edit" value="<?php echo $id_update ;?>">

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $mode == 'edit' ? $clientsById['nom'] : " ";?>" placeholder="Veuillez entrer votre nom" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $mode == 'edit' ? $clientsById['prenom'] : " ";?>" placeholder="Veuillez entrez votre prénom" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $mode == 'edit' ? $clientsById['email'] : " " ;?>" placeholder="name@example.com" required>
                </div>

                <div class="form-group">
                    <label for="cheveux">Type de cheveux</label>
                    <select class="form-control" id="cheveux" name="cheveux" value="<?php echo $mode == 'edit' ? $clientsById['cheveux'] : " " ; ?>">
                    <option>Lisses</option>
                    <option>Bouclés</option>
                    <option>Frisés</option>
                    <option>Défrisés</option>
                    <option>Colorées</option>
                    <option>Crépus</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="produits">Choix de votre produit</label>
                    <select multiple class="form-control" id="produits" name="produits" value="<?php echo $mode == 'edit' ? $clientsById['produits'] : "" ;?>">
                    <option value="Beurre de karite">Beurre de karite</option>
                    <option value="Huile de coco">Huile de coco</option>
                    <option value="Huile de ricin">Huile de ricin</option>
                    <option value="African soap">African soap</option>
                    </select>
                </div>
                <button class="btn btn-outline-info">Enregistrer</button>
            </form>

            <!-- FIN FORMULAIRE -->


    
        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>