<?php
    include 'security.php';
?>

<article id="members">
    <h2 class="major">Members</h2>
    <div class="toast-container toast">
        <span class="toast-message"></span>
        <div class="toast-progress"></div>
    </div>
    <form method="post" action="">
        <div class="fields">
            <div class="field">
                <input type="text" name="first_name" placeholder="First Name" required />
            </div>
            <div class="field">
                <input type="text" name="last_name" placeholder="Last Name" required />
            </div>
            <div class="field">
                <button type="submit" name="add_customer" class="primary fit">
                    <i class="fa fa-plus-circle"></i> New Member
                </button>
            </div>
        </div>
    </form>

    <hr  />
    <h3>Members List</h3>
    <p>Sorted by balance (lowest to highest).</p>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $c): ?>
                <tr style="<?php echo $c['IS_ACTIVE'] == 0 ? 'opacity: 0.5; background: rgba(255,0,0,0.05);' : ''; ?>">
                <?php 
                    $balance = (float) $c['BALANCE'];
                    $color = $balance >= 0 ? 'rgb(125,227,211)' : 'rgb(227, 125, 125);';
                    $plus = $balance > 0 ? '+' : '';
                ?>
                    <td><?= $c['FIRST_NAME'] . ' ' . $c['LAST_NAME']; ?></td>
                    <td style="color: <?= $color; ?>;font-weight: bold;"><?= $plus . number_format($balance, 0); ?> €</td>
                    <td>
                        <?php if ($c['IS_ACTIVE'] == 1): ?>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="id_customer" value=<?= $c['ID_CUSTOMER'] ?>>
                            <input type="hidden" name="set_active" value=0>
                            <button type="submit" name="toggle_cust"
                                    class="icon solid fa-eye"
                                    title="Hide"
                                    style="background:none; box-shadow:none; border:0; cursor:pointer;font-size: 1.2rem;">
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="id_customer" value=<?= $c['ID_CUSTOMER'] ?>>
                            <input type="hidden" name="set_active" value=1>
                            <button type="submit" name="toggle_cust"
                                    class="icon solid fa-eye-slash"
                                    title="Show"
                                    style="background:none; box-shadow:none; border:0; cursor:pointer;font-size: 1.2rem;">
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</article>