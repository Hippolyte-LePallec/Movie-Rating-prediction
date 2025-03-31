<div class="dtitle w3-container w3-teal">
    <h2 class="w3-center">Classements des étudiants par année</h2>
</div>

<div class="w3-container" style="margin: auto; padding: 20px; max-width: 800px;">
    <?php foreach ($classementsParAnnee as $annee => $classements): ?>
        <div class="w3-card-4 w3-margin w3-white">
            <header class="w3-container w3-teal">
                <h4 class="w3-center">Classement pour l'année <?= htmlspecialchars($annee) ?></h4>
            </header>

            <div class="w3-container w3-padding">
                <table class="w3-table w3-bordered w3-white w3-card-4">
                    <thead>
                        <tr class="w3-teal">
                            <th class="w3-center">Nom</th>
                            <th class="w3-center">Prénom</th>
                            <th class="w3-center">Moyenne</th>
                            <th class="w3-center">Rang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classements)): ?>
                            <?php foreach ($classements as $classement): ?>
                                <tr>
                                    <td class="w3-center"><?= htmlspecialchars($classement['nometu'] ?? 'Non défini') ?></td>
                                    <td class="w3-center"><?= htmlspecialchars($classement['prenometu'] ?? 'Non défini') ?></td>
                                    <td class="w3-center"><?= isset($classement['moyenne']) ? htmlspecialchars($classement['moyenne']) : 'Non calculée' ?></td>
                                    <td class="w3-center"><?= htmlspecialchars($classement['rang'] ?? 'Non défini') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="w3-center">Aucun classement trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>
