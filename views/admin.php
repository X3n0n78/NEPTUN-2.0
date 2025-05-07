<h1>Adminisztráció</h1>

<h2>Felhasználók</h2>
<table class="responsive-table">
    <thead>
        <tr>
            <th>Felhasználónév</th>
            <th>Email</th>
            <th>Szerepkörök</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <?php
                $userRoles = $userModel->getRoles($user['id']);
                echo implode(', ', array_map('htmlspecialchars', $userRoles));
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Szerepkörök</h2>
<table class="responsive-table">
    <thead>
        <tr>
            <th>Szerepkör</th>
            <th>Jogosultságok</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?= htmlspecialchars($role['role_name']) ?></td>
            <td>
                <?php
                $perms = $roleModel->getRolePermissions($role['id']);
                echo implode(', ', array_map('htmlspecialchars', $perms));
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
