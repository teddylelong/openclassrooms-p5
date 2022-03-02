<h1>Créer un nouvel utilisateur</h1>

<form action="/user/insert/" method="POST">
    <label for="firstname">Prénom :</label>
    <input type="text" name="firstname" id="firstname">

    <label for="lastname">Nom :</label>
    <input type="text" name="lastname" id="lastname">

    <label for="email">Adresse e-mail :</label>
    <input type="email" name="email" id="email">

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password">

    <label for="password_confirmation">Confirmez le mot de passe :</label>
    <input type="password" name="password_confirmation" id="password_confirmation">

    <p>Ce nouvel utilisateur aura-t-il les droits d'administrateur ?</p>
    <input type="radio" name="is_admin" id="is_admin_y" value="1">
    <label for="is_admin_y">Oui</label>

    <input type="radio" name="is_admin" id="is_admin_n" value="0">
    <label for="is_admin_n">Non</label>

    <input type="submit" value="Créer l'utilisateur">
</form>

