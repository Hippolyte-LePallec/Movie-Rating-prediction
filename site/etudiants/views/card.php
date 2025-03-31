<div class="dtitle w3-container w3-teal">
    <h2 class="w3-center">Fiche étudiant</h2>
</div>

<div class="w3-container" style="margin: auto; padding: 20px; max-width: 800px;">
    <div class="w3-card-4 w3-margin w3-white">
        <header class="w3-container w3-teal">
            <h3 class="w3-center">Informations de l'étudiant</h3>
        </header>

        <div class="w3-container w3-padding">
            <div class="w3-row w3-margin-bottom">
                <div class="w3-col s6 w3-padding-small w3-light-grey"><strong>Numéro étudiant:</strong></div>
                <div class="w3-col s6 w3-padding-small"><?= htmlspecialchars($studentData['numetu']) ?></div>
            </div>
            <div class="w3-row w3-margin-bottom">
                <div class="w3-col s6 w3-padding-small w3-light-grey"><strong>Prénom:</strong></div>
                <div class="w3-col s6 w3-padding-small"><?= htmlspecialchars($studentData['prenometu']) ?></div>
            </div>
            <div class="w3-row w3-margin-bottom">
                <div class="w3-col s6 w3-padding-small w3-light-grey"><strong>Nom:</strong></div>
                <div class="w3-col s6 w3-padding-small"><?= htmlspecialchars($studentData['nometu']) ?></div>
            </div>
        </div>

        <footer class="w3-container w3-teal w3-center">
            <form action="" method="POST" style="margin: 0;">
                <button class="w3-button w3-white w3-round w3-margin-top w3-margin-bottom" type="submit" name="retour_liste">
                    Retour à la liste
                </button>
            </form>
        </footer>
    </div>
</div>

<div class="dtitle w3-container w3-teal" style="margin-top: 20px;">
    <h3 class="w3-center">Classements par module</h3>
</div>

<div class="w3-container" style="margin: auto; padding: 20px; max-width: 800px;">
    <div class="w3-card-4 w3-margin w3-white">
        <header class="w3-container w3-teal">
            <h4 class="w3-center">Classements</h4>
        </header>

        <div class="w3-container w3-padding">
            <table class="w3-table w3-bordered w3-white w3-card-4">
                <thead>
                    <tr class="w3-teal">
                        <th class="w3-center">Nom du module</th>
                        <th class="w3-center">Moyenne</th>
                        <th class="w3-center">Rang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classementData)): ?>
                        <?php foreach ($classementData as $classement): ?>
                            <tr>
                                <td class="w3-center"><?= htmlspecialchars($classement['nommod'] ?? 'Non défini') ?></td>
                                <td class="w3-center"><?= isset($classement['moyenne']) ? htmlspecialchars($classement['moyenne']) : 'Non calculée' ?></td>
                                <td class="w3-center"><?= htmlspecialchars($classement['rang'] ?? 'Non défini') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="w3-center">Aucun classement trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
