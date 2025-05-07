<div class="admin-panel">
    <h1>Adminisztráció</h1>

    <!-- Felhasználók táblázata -->
    <section class="admin-section">
        <h2>Felhasználók <a href="index.php?page=admin&action=add_user" class="btn btn-primary">+ Új</a></h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']) ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']) ?>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Felhasználónév</th>
                    <th>Email</th>
                    <th>Szerepkörök</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php
                            $roles = $user['roles'] ?? [];
                            if (!is_array($roles)) $roles = $roles ? [$roles] : [];
                            echo htmlspecialchars(implode(', ', $roles));
                            ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin&action=edit_user&id=<?= $user['id'] ?>" class="btn btn-edit">Szerkesztés</a>
                            <?php if ($user['id'] != 1): ?>
                                <a href="index.php?page=admin&action=delete_user&id=<?= $user['id'] ?>"
                                   class="btn btn-delete"
                                   onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Szerkesztő űrlap (felhasználóhoz) -->
    <?php if (isset($editUser)): ?>
        <div class="admin-form-card">
            <h2><?= ($editUser['id'] ? 'Felhasználó szerkesztése' : 'Új felhasználó') ?></h2>
            <form method="post" action="index.php?page=admin&action=save_user">
                <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <label>Felhasználónév: <input type="text" name="username" value="<?= htmlspecialchars($editUser['username']) ?>" required></label>
                <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($editUser['email']) ?>" required></label>
                <label>Jelszó: <input type="password" name="password" <?= $editUser['id'] ? '' : 'required' ?>></label>
                <label>Szerepkörök:
                    <select name="roles[]" multiple required>
                        <?php foreach ($allRoles as $role): ?>
                            <option value="<?= $role['id'] ?>" <?= in_array($role['id'], $editUser['role_ids']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['role_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button type="submit" class="btn btn-primary">Mentés</button>
                <a href="index.php?page=admin" class="btn btn-secondary">Mégse</a>
            </form>
        </div>
    <?php endif; ?>

    <!-- Szerepkörök -->
<section class="admin-section">
    <h2>Szerepkörök <a href="index.php?page=admin&add_role=1" class="btn btn-primary">Új szerepkör</a></h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Szerepkör</th>
                <th>Jogosultságok</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
            <tr>
                <td><?= htmlspecialchars($role['role_name']) ?></td>
                <td>
                    <?php
                    if (isset($role['permissions'])) {
                        if (is_array($role['permissions'])) {
                            echo htmlspecialchars(implode(', ', $role['permissions']));
                        } else if (is_string($role['permissions'])) {
                            $permsArray = !empty($role['permissions']) ? explode(',', $role['permissions']) : [];
                            echo htmlspecialchars(implode(', ', $permsArray));
                        } else {
                            echo '';
                        }
                    } else {
                        echo '';
                    }
                    ?>
                </td>
                <td>
                    <a href="index.php?page=admin&edit_role=<?= $role['id'] ?>" class="btn btn-edit">Szerkesztés</a>
                    <?php if ($role['role_name'] !== 'admin'): ?>
                        <a href="index.php?page=admin&delete_role=<?= $role['id'] ?>"
                           class="btn btn-delete"
                           onclick="return confirm('Biztosan törlöd ezt a szerepkört?')">Törlés</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
</div>
