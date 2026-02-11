<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <h2>Nieuwe Boeking</h2>

        <form method="POST" action="<?= APP_URL ?>/boekingen/create" class="form">
            <div class="form-row">
                <div class="form-group">
                    <label for="klantId">Klant *</label>
                    <select id="klantId" name="klantId" required>
                        <option value="">Selecteer klant</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bestemmingId">Bestemming *</label>
                    <select id="bestemmingId" name="bestemmingId" required>
                        <option value="">Selecteer bestemming</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="startDatum">Start Datum *</label>
                    <input type="date" id="startDatum" name="startDatum" required>
                </div>

                <div class="form-group">
                    <label for="eindDatum">Eind Datum *</label>
                    <input type="date" id="eindDatum" name="eindDatum" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="aantalVolwassenen">Aantal Volwassenen *</label>
                    <input type="number" id="aantalVolwassenen" name="aantalVolwassenen" min="1" value="1" required>
                </div>

                <div class="form-group">
                    <label for="aantalKinderen">Aantal Kinderen (2-12 jaar)</label>
                    <input type="number" id="aantalKinderen" name="aantalKinderen" min="0" value="0">
                </div>

                <div class="form-group">
                    <label for="aantalBabys">Aantal Baby's (0-2 jaar)</label>
                    <input type="number" id="aantalBabys" name="aantalBabys" min="0" value="0">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Boeking Aanmaken</button>
                <a href="<?= APP_URL ?>/boekingen" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
