<?php

  require_once 'config/configoriginel.php';

  try {
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USER, MDP, $options);
  } catch (Exception $e) {
    echo $e->getMessage();

  }


// MODIFICATION CLIENTS

  $mode = 'edit';

  if(isset($_GET['id_edit']) && !empty($_GET['id_edit'])) {
    
    $id_edit = htmlentities($_GET['id_edit']);
    $mode = 'edit';

    $reqById = $bdd->prepare("SELECT * FROM clients WHERE id=:id_edit");
    $reqById->execute(array(
                          'id_edit' => $id_edit  
    ));

    $clientsById = $reqById->fetch();

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

            <h1>Formulaire - Souscription clients</h1>
            <br>

            <form method="post" action="save_originel.php">

              <input type="hidden" name="mode" value=<?php echo $mode;?>>
              <input type="hidden" name="id_edit" value=<?php echo $id_edit; ?>>

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required placeholder="Veuillez entrer votre nom" value=<?php echo $mode == 'edit'? $clientsById['nom'] : " " ?>>
                </div>

                <div class="form-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="Veuillez entrez votre prénom" value=<?php echo $mode == 'edit' ? $clientsById['prenom'] : " "?>>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com" value=<?php echo $mode == 'edit' ? $clientsById['email'] : " " ?>>
                </div>

                <div class="form-group">
                    <label for="cheveux">Type de cheveux</label>
                    <select class="form-control" id="cheveux" name="cheveux" value=<?php echo $mode == 'edit' ? $clientsById['cheveux'] : " " ?>>
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
                    <select multiple class="form-control" id="produits" name="produits" value=<?php echo $mode == 'edit' ? $clientsById['produits'] : " " ?>>
                    <option>Beurre de karite</option>
                    <option>Huile de coco</option>
                    <option>Huile de ricin</option>
                    <option>African soap</option>
                    </select>
                </div>
                <button class="btn btn-outline-info">Enregistrer</button>
    

            <!-- FIN FORMULAIRE -->


    
        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>