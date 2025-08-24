<?php
/**
 * @var string $modalId       Unique modal ID
 * @var string $title         Modal title
 * @var string $action        Form action URL
 * @var array  $fields        Fields config [ [name, label, type, options?], ... ]
 *                            type can be: text, password, select, email, number
 *                            options: array of [value => label] (for selects)
 * @var array|null $values    Default values (for edit)
 */
?>

<div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="<?= $action ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="<?= $modalId ?>Label"><?= htmlspecialchars($title) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <?php if (!empty($values['id'])): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($values['id'], ENT_QUOTES, 'UTF-8') ?>">
          <?php endif; ?>

          <div class="row g-3">
<?php foreach ($fields as $field):
  [$name, $label, $type] = $field;
  $options = $field[3] ?? []; // for selects
  $value = array_key_exists($name, $values) ? $values[$name] : '';
?>
  <div class="col-md-6">
    <label for="<?= $modalId . '_' . $name ?>" class="form-label"><?= htmlspecialchars($label) ?></label>

<?php if ($type === 'password'): ?>
  <input type="password"
         class="form-control"
         id="<?= $modalId . '_' . $name ?>"
         name="<?= $name ?>"
         value=""
         <?= empty($values) ? 'required' : '' ?>
         placeholder="<?= empty($values) ? '' : 'Leave blank to keep current password' ?>">

    <?php elseif ($type === 'select'): ?>
      <select class="form-select"
              id="<?= $modalId . '_' . $name ?>"
              name="<?= $name ?>"
              required>
        <?php if (empty($values)): ?>
          <option value="">-- Select <?= htmlspecialchars($label) ?> --</option>
        <?php endif; ?>
        <?php foreach ($options as $optVal => $optLabel): ?>
          <option value="<?= htmlspecialchars($optVal, ENT_QUOTES, 'UTF-8') ?>"
            <?= ((string)$value === (string)$optVal) ? 'selected' : '' ?>>
            <?= htmlspecialchars($optLabel, ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>

    <?php else: ?>
      <!-- Default input (text, number, etc.) -->
      <input type="<?= $type ?>"
             class="form-control"
             id="<?= $modalId . '_' . $name ?>"
             name="<?= $name ?>"
             value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
             required>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
