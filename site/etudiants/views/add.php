<div class="dtitle w3-container w3-teal">
    <h2><?= $editData ? "Modifier un étudiant" : "Création d'un nouvel étudiant" ?></h2>
</div>

<div class="w3-container" style="max-width: 1000px; margin: auto;">
    <form action="<?= $_SERVER['PHP_SELF'] . "?element=etudiants&action=add" ?>" method="post" class="w3-container w3-card-4 w3-light-grey">
        <input type="hidden" name="numetu" value="<?= htmlspecialchars($editData['numetu'] ?? '') ?>">
        <h3 class="w3-center">Veuillez remplir les informations ci-dessous</h3>

        <fieldset class="w3-margin-bottom">
            <legend class="w3-text-teal"><strong>Informations principales</strong></legend>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="prenometu">Prénom :</label>
                    <input class="w3-input w3-border" type="text" id="prenometu" name="prenometu" value="<?= htmlspecialchars($prenometu) ?>" required>
                </div>
                <div class="w3-half">
                    <label for="nometu">Nom :</label>
                    <input class="w3-input w3-border" type="text" id="nometu" name="nometu" value="<?= htmlspecialchars($nometu) ?>" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-full">
                    <label for="datnaietu">Date de naissance :</label>
                    <input class="w3-input w3-border" type="date" id="datnaietu" name="datnaietu" value="<?= htmlspecialchars($datnaietu) ?>" required>
                </div>
            </div>
        </fieldset>

        <fieldset class="w3-margin-bottom">
            <legend class="w3-text-teal"><strong>Informations académiques</strong></legend>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="annetu">Année :</label>
                    <select class="w3-select w3-border" id="annetu" name="annetu" required>
                        <option value="" disabled <?= $annetu ? "" : "selected" ?>>Choisissez une année</option>
                        <?php for ($i = 1; $i <= 2; $i++): ?>
                            <option value="<?= $i ?>" <?= $annetu == $i ? "selected" : "" ?>>Année <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="w3-half">
                    <label for="remetu">Remarques :</label>
                    <input class="w3-input w3-border" type="text" id="remetu" name="remetu" value="<?= htmlspecialchars($remetu) ?>" maxlength="40">
                </div>
            </div>
        </fieldset>

        <fieldset class="w3-margin-bottom">
            <legend class="w3-text-teal"><strong>Adresse et contact</strong></legend>
            <div class="w3-row-padding">
                <div class="w3-full">
                    <label for="adretu">Adresse :</label>
                    <textarea class="w3-input w3-border" id="adretu" name="adretu" required><?= htmlspecialchars($adretu) ?></textarea>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="cpetu">Code postal :</label>
                    <input class="w3-input w3-border" type="text" id="cpetu" name="cpetu" value="<?= htmlspecialchars($cpetu) ?>" maxlength="5" required>
                </div>
                <div class="w3-half">
                    <label for="viletu">Ville :</label>
                    <input class="w3-input w3-border" type="text" id="viletu" name="viletu" value="<?= htmlspecialchars($viletu) ?>" maxlength="20" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="teletu">Téléphone :</label>
                    <input class="w3-input w3-border" type="text" id="teletu" name="teletu" value="<?= htmlspecialchars($teletu) ?>" maxlength="14" required>
                </div>
                <div class="w3-half">
                    <label for="sexetu">Sexe :</label>
                    <select class="w3-select w3-border" id="sexetu" name="sexetu" required>
                        <option value="" disabled <?= $sexetu ? "" : "selected" ?>>Choisissez un sexe</option>
                        <option value="M" <?= $sexetu === "M" ? "selected" : "" ?>>Masculin</option>
                        <option value="F" <?= $sexetu === "F" ? "selected" : "" ?>>Féminin</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <div class="w3-center">
            <input class="w3-button w3-teal" type="submit" name="confirm" value="<?= $editData ? "Modifier" : "Créer" ?>">
        </div>
    </form>
</div>
