<div class="dtitle w3-container w3-teal w3-round">
    <h2 class="w3-center">Liste des étudiants</h2>
</div>

<div class="w3-container w3-margin-top" style="width: 100%; overflow-x: auto;">
    <!-- Formulaire de recherche -->
    <form action="<?= $_SERVER['PHP_SELF'] ?>?element=etudiants&action=list" method="POST">
        <table class="w3-table w3-bordered w3-card w3-round w3-margin-bottom" style="table-layout: fixed; width: 100%;">
            <thead>
                <tr class="w3-light-grey">
                    <th><input class="w3-input w3-border" type="text" name="searchNumetu" placeholder="Numéro"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchPrenometu" placeholder="Prénom"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchNometu" placeholder="Nom"></th>
                    <th><input class="w3-input w3-border" type="date" name="searchDatnaietu"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchAnnetu" placeholder="Année"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchAdretu" placeholder="Adresse"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchCpetu" placeholder="Code postal"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchViletu" placeholder="Ville"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchTeletu" placeholder="Téléphone"></th>
                    <th><input class="w3-input w3-border" type="text" name="searchSexetu" placeholder="Sexe"></th>
                    <th>
                        <button class="w3-button w3-teal w3-round" type="submit" name="rechercher">
                            <i class="fa fa-search"></i> Rechercher
                        </button>
                    </th>
                </tr>
            </thead>
        </table>
    </form>

    <!-- Tableau principal -->
    <table class="w3-table w3-bordered w3-striped w3-hoverable w3-card w3-round" style="table-layout: fixed; width: 100%;">
        <thead>
            <tr class="w3-teal">
                <th class="w3-center">Numéro étudiant</th>
                <th class="w3-center">Prénom</th>
                <th class="w3-center">Nom</th>
                <th class="w3-center">Date de naissance</th>
                <th class="w3-center">Année</th>
                <th class="w3-center">Adresse</th>
                <th class="w3-center">Code postal</th>
                <th class="w3-center">Ville</th>
                <th class="w3-center">Téléphone</th>
                <th class="w3-center">Sexe</th>
                <th class="w3-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etudiants)): ?>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['numetu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['prenometu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['nometu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['datnaietu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['annetu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['adretu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['cpetu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['viletu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['teletu']) ?></td>
                        <td class="w3-center"><?= htmlspecialchars($etudiant['sexetu']) ?></td>
                        <td class="w3-center">
                            <div style="display: flex; justify-content: center; gap: 5px;">
                                <!-- Bouton Voir -->
                                <form action="" method="POST" style="margin: 0;">
                                    <input type="hidden" name="numetu" value="<?= $etudiant['numetu'] ?>">
                                    <button class="w3-button w3-green w3-round w3-small" type="submit" name="voir_fiche" title="Voir">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </form>

                                <!-- Bouton Modifier -->
                                <form action="" method="POST" style="margin: 0;">
                                    <input type="hidden" name="numetu" value="<?= $etudiant['numetu'] ?>">
                                    <button class="w3-button w3-blue w3-round w3-small" type="submit" name="modifier" title="Modifier">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </form>

                                <!-- Bouton Supprimer -->
                                <form action="" method="POST" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                    <input type="hidden" name="numetu" value="<?= $etudiant['numetu'] ?>">
                                    <button class="w3-button w3-red w3-round w3-small" type="submit" name="supprimer" title="Supprimer">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="w3-center">Aucun étudiant trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
