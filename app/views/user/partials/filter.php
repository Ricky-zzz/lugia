<?php
/**
 * @param string $action The form action (e.g., "/admin/flight-schedules")
 * @param array $fields  Array of filters (name, label, placeholder, type)
 */
function renderFilterSidebar(string $action, array $fields) {
?>
<form id="filterForm" method="get" action="<?= htmlspecialchars($action, ENT_QUOTES, 'UTF-8') ?>" class="h-100 d-flex flex-column">
    <div class="flex-grow-1">
        <?php foreach ($fields as $field): 
            $name = $field['name'];
            $label = $field['label'];
            $placeholder = $field['placeholder'] ?? '';
            $type = $field['type'] ?? 'text';
            $value = $_GET[$name] ?? '';
            $enabled = !empty($value);
            $checkboxId = "enable" . ucfirst($name);
            $inputId = $name . "Filter";
        ?>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="<?= $checkboxId ?>" <?= $enabled ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="<?= $checkboxId ?>">
                        <?= htmlspecialchars($label) ?>
                    </label>
                </div>
                <?php if ($type === 'select'): ?>
                    <select class="form-select form-select-sm mt-2" id="<?= $inputId ?>" name="<?= htmlspecialchars($name) ?>" <?= !$enabled ? 'disabled' : '' ?>>
                        <option value="">-- Select --</option>
                        <?php foreach ($field['options'] as $val => $txt): ?>
                            <option value="<?= htmlspecialchars($val) ?>" <?= $value == $val ? 'selected' : '' ?>><?= htmlspecialchars($txt) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input type="<?= $type ?>" class="form-control form-control-sm mt-2"
                           id="<?= $inputId ?>"
                           name="<?= htmlspecialchars($name) ?>"
                           value="<?= htmlspecialchars($value) ?>"
                           placeholder="<?= htmlspecialchars($placeholder) ?>"
                           <?= !$enabled ? 'disabled' : '' ?>>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-search me-1"></i>Filter
        </button>
        <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" 
           class="btn btn-outline-secondary btn-sm" id="clearFilters">
            <i class="bi bi-x-circle me-1"></i>Clear
        </a>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const filters = <?= json_encode(array_map(fn($f) => [
        'checkbox' => "enable" . ucfirst($f['name']),
        'input'    => $f['name'] . "Filter"
    ], $fields)) ?>;

    filters.forEach(f => {
        const cb = document.getElementById(f.checkbox);
        const input = document.getElementById(f.input);
        if (!cb || !input) return;
        cb.addEventListener("change", function () {
            input.disabled = !this.checked;
            if (!this.checked) input.value = "";
        });
    });

    const clearBtn = document.getElementById("clearFilters");
    if (clearBtn) {
        clearBtn.addEventListener("click", function (e) {
            e.preventDefault();
            filters.forEach(f => {
                const cb = document.getElementById(f.checkbox);
                const input = document.getElementById(f.input);
                if (cb && input) {
                    cb.checked = false;
                    input.disabled = true;
                    input.value = "";
                }
            });
            window.location.href = this.closest('form').action;
        });
    }
});
</script>
<?php } ?>
