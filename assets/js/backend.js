/* Code pour backend user */
$('#btn_user').click(function(){
    // On ajoute l'action au formulaire
    $('#form_utilisateur').attr('action','action.php?e=ajoutUser');
    // On affiche la div contenant le formulaire
    $('#div_user').show(1000);
});
// Pour l'édition de l'utilisateur
$('.editUser').click(function(){
    let user_id = $(this).attr('data-id');
    $.ajax({
        url: 'action.php?e=printuser&userid='+user_id,
        type: 'GET',
        //data: 'userid:'+user_id,
        success:function(response){
            // On parse les données JSON
            let utilisateur = jQuery.parseJSON(response);
            // On ajoute les valeurs au formulaire
            $('#email').val(utilisateur.Client_Email);
            $('#nom').val(utilisateur.Client_Nom);
            $('#prenom').val(utilisateur.Client_Prenom);
            $('#credit').val(utilisateur.Client_Credit);
            // On met à jour l'action du formulaire
            $('#form_utilisateur').attr('action','action.php?e=editUser&id='+utilisateur.Client_ID);
            // On affiche la div contenant le formulaire
            $('#div_user').show(1000);


        }
    });
});
$('.delUser').click(function(){
    let user_id = $(this).attr('data-id');
    if(confirm('Etes vous sur de vouloir effectuer cette action??'))
    {
        document.location.href="action.php?e=deluser&id="+user_id;
    }
});
/* Fin utilisateur */
/* Début catégorie */
$('#btn-categorie').click(function(){
    // On ajoute l'action au formulaire
    $('#form_categorie').attr('action','action.php?e=ajoutCategorie');
    // On affiche la div contenant le formulaire
    $('#div_categorie').show(1000);
});
$('.editcategorie').click(function(){
    let cat_id = $(this).attr('data-id');
    $.ajax({
        url: 'action.php?e=printCategorie&id='+cat_id,
        type:'get',
        success: function(response){
            let categorie = jQuery.parseJSON(response);
            $('#nom').val(categorie.Categorie_Nom);
            $('#form_categorie').attr('action','action.php?e=editCategorie&id='+categorie.Categorie_ID);
            $('#div_categorie').show(1000);
        }
    });
});
$('.delcategorie').click(function(){
    let cat_id = $(this).attr('data-id');
    if(confirm('Etes vous sur de vouloir supprimer la catégorie?'))
    {
        document.location.href = 'action.php?e=delCategorie&id='+cat_id;
    }
});
// Fin catégorie ticket
// Début ticket
$('#nombre').on('blur',function(){
    let valeur = $(this).val();
    let contenu = $('#partie');
    if(valeur > 0){
        // On affiche la div partie
        contenu.show(1000);
    }
    else{
        // On cache la div partie
        contenu.hide();
    }
});
$('#add_partie_btn').click(function(){
    let valeur = $('#nombre').val();
    if(valeur > 0){
        let contenu = $('#partie');
        $('#add_partie').append(contenu.html());
    }
    else{
        alert('Veuillez ajouter des tickets!!');
    }
});
$('#btn-ticket').click(function(){
    $('#form_ticket').attr('action','action.php?e=ajoutTicket');
    $('#div_ticket').show(1000);
});
$('.delticket').click(function(){
    let ticket_id = $(this).attr('data-id');
    if(confirm('Etes vous sur de vouloir supprimer le ticket?'))
    {
        document.location.href="action.php?e=delTicket&id="+ticket_id;
    }
});
/*Pour la pagination*/
$('#pagination').on('change',function(){
    let page = $($this).val();
    document.location.href="produits.php?page="+page;
});
/*afficher le formulaire produit
*/
$('#add_produit').click(function(){
    $('#form_produit').show(2000);
});

