<?php
require_once('../config.php');
// On vérifie si l'utilisateur est connecté
if(!verifAdmin())
{
    // Si l'utilisateur n'est pas connecté
    $message = 'Veuillez vous connecter';
    header('location:login.php?msg='.urlencode($message));
    exit;
}
include('inc/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des utilisateurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des utilisateurs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des utilisateurs</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-default" name="btn_user" id="btn_user">
                        Ajouter un utilisateur
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Email</th>
                      <th>Crédit</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // On va chercher les catégories dans la BDD
                    $liste_utilisateurs = $db->query('SELECT * FROM `Table_Client`');
                    // On vérifie qu'on a au moins une catégorie
                    if($liste_utilisateurs->rowCount() >= 1)
                    {
                        // On créer l'objet catégorie
                        $utilisateurs = $liste_utilisateurs->fetchAll(PDO::FETCH_OBJ);
                        foreach($utilisateurs as $user)
                        {
                            echo '<tr>';
                            echo '<td>'.$user->Client_ID.'</td>';
                            echo '<td>'.$user->Client_Nom.'</td>';
                            echo '<td>'.$user->Client_Prenom.'</td>';
                            echo '<td>'.$user->Client_Email.'</td>';
                            echo '<td>'.$user->Client_Credit.'</td>';
                            echo '<td>';
                            echo '<button name="edit" class="btn btn-primary editUser" data-id="'.$user->Client_ID.'">Modifier</button>';
                            echo '<button name="del" class="btn btn-danger delUser" data-id="'.$user->Client_ID.'">Supprimer</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<div class="btn btn-warning">Aucun utilisateur</div>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- Formulaire d'ajout/édition -->
          <div class="col-12" id="div_user" <?php if(!empty($_SESSION['form_utilisateur'])) echo 'class="affiche"'; ?>>
              <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajouter/éditer un utilisateur</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
              if(!empty($_SESSION['form_utilisateur']))
              {
                // On va déserialiser notre session
                $utilisateur = unserialize($_SESSION['form_utilisateur']);
              }
              else
              {
                // Si la session est vide on initialise la variable utilisateur vide.
                $utilisateur = '';
              }
              ?>
              <form name="utilisateur" method="post" action="<?php if(!empty($utilisateur)) echo 'action.php?e=ajoutUser'; ?>" id="form_utilisateur">
                <div class="card-body">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php if(!empty($utilisateur['email'])) echo strip_tags($utilisateur['email']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php if(!empty($utilisateur['nom'])) echo strip_tags($utilisateur['nom']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?php if(!empty($utilisateur['prenom'])) echo strip_tags($utilisateur['prenom']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="credit">Crédit</label>
                    <input type="number" class="form-control" id="credit" name="credit" value="<?php if(!empty($utilisateur['credit'])) echo strip_tags($utilisateur['credit']); ?>">
                  </div>      
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- Fin formulaire ajout/édition -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('inc/footer.php');
?>