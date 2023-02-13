<?php
require_once('../config.php');
require_once('../core/class.produit.php');
// On vérifie si l'utilisateur est connecté
if(!verifAdmin())
{
    // Si l'utilisateur n'est pas connecté
    $message = 'Veuillez vous connecter';
    header('location:login.php?msg='.urlencode($message));
    exit;
}
include('inc/header.php');
// on verifie si on est en édition
if(isset($_GET['edit']) && !empty($_GET['id']))
{
    $produit_edit = new Produit($_GET['id']);
    $action = 'action.php?e=editproduit';
    $visibilite = 'display:block';
}
else
{
    $action = 'action.php?e=ajoutproduit';
    $visibilite = 'display:none';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des produits</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des produits</li>
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
                <h3 class="card-title">Liste des produits</h3>
                    <button name="addproduit" id="add_produit" class="btn btn-primary">Ajouter un produit</button>
                <div class="card-tools" id="form_produit" style="<?php echo $visibilite;?>">
                <form method="post" name="produit" action="<?php echo $action;?>">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="number" name="prix" value="<?php if(!empty($produit_edit)) echo $produit_edit->getPrix(); ?>" class="form-control float-right" placeholder="prix">
                        <input type="number" name="valeur" value="<?php if(!empty($produit_edit)) echo $produit_edit->getValeur(); ?>" class="form-control float-right" placeholder="valeur">
                        <input type="number" name="quantite" value="<?php if(!empty($produit_edit)) echo $produit_edit->getQuantite(); ?>" class="form-control float-right" placeholder="quantite">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                        <?php
                            // on regade si le tri est ASC ou DESC
                        if(!isset($_GET['order']) || $_GET['order'] == 'ASC')
                        {
                            $order = 'DESC';
                        }
                        else
                        {
                            $order = 'ASC';
                        }
                        // on s'ocupe de la pagination
                        // on va veriifier sur quel page on est
                        if(!empty($_GET['page']))
                        {
                            $page = (int) $_GET['page'];
                        }
                        else
                        {
                            $page = 1;
                        }
                        ?>
                      <th><a href='produits.php?triid=true&order=<?php echo $order;?>&page=<?php echo $page;?>'>ID</th>
                      <th><a href='produits.php?triprix=true&order=<?php echo $order;?>&page=<?php echo $page;?>'>Prix</th>
                      <th><a href='produits.php?trivaleur=true&order=<?php echo $order;?>&page=<?php echo $page;?>'>Valeur</th>
                      <th><a href='produits.php?triqte=true&order=<?php echo $order;?>&page=<?php echo $page;?>'>quantité</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // On va chercher les catégories dans la BDD
                    // on va preparer notre tableau d'argument
                    $tri = array();
                    if(isset($_GET['triid']))
                        $tri['order'] = 'Produit_ID';
                        else if (isset($_GET['triprix']))
                        $tri['order'] = 'Produit_Prix';
                        else if (isset($_GET['trivaleur']))
                        $tri['order'] = 'Produit_Valeur';
                        else if (isset($_GET['triqte']))
                        $tri['order'] = 'Produit_Quantite';
                        // on va definir l'ordre de tri
                        if(isset($_GET['orderby']))
                        $tri['orderby'] = $_GET['orderby'];
                        // on définit la page
                        $tri['page'] = $page;
                        // on definit le nombre de produits par page
                        $tri['limit'] = 10;
                    $liste_produits = Produit::liste($tri);
                    if($liste_produits)
                    {
                        foreach($liste_produits as $prod)
                        {
                            // on instancie  notre objet produit
                            $produit = new Produit($prod->Produit_ID);
                            echo '<tr>';
                            echo '<td>'.$produit->getId().'</td>';
                            echo '<td>'.$produit->getPrix().'</td>';
                            echo '<td>'.$produit->getValeur().'</td>';
                            echo '<td>'.$produit->getQuantite().'</td>';
                            echo '<td><a href="produit.php?e=editproduit&id=<?php echo $produit->getId(); ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a></td>';
                            echo '<td><a href="produit.php?e=delproduit&id=<?php echo $produit->getId(); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<div class=btn btn_warning>Aucun produit</div>';
                    }
                    
                    ?>
                  </tbody>
                </table>
                <!--Notre pagination-->
                <div class="pagination">
                    <?php 
                    if(!empty($_GET['page']) || $page == 1)
                    {
                        //on va compter le nombre de produits présent dans la BDD
                        $nb_produit = count($liste_produits);
                        // on va diviser le nombre de produits  par la limite de produit par page
                        $nb_page = ceil($nb_produit/$tri['limit']);
                        if($page>1)
                        echo '<a href="produits.php?page='.($page-1).'">Precedend</a>';
                        // on fait une liste déroulante pour lister des pages
                        echo '<select name="pagination" id= "pagination" class="form-control">';
                        for($i=1;$i<=$nb_page;$i++)
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        echo '</select>';
                        //on verifie si on est pas sur la derniere page on affiche le buton suivant
                        if($page < $nb_page)
                        {
                            echo '<a href="produits.php?page='.($page+1).'">Suivant</a>';
                        }
                    }
                    
                    ?>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
