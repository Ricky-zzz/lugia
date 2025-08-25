<form id="filterForm" method="get" action="/admin/airlines" class="h-100 d-flex flex-column">
    <div class="flex-grow-1">
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableIATA"
                    <?= !empty($_GET['iata']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-semibold" for="enableIATA">IATA</label>
            </div>
            <input type="text" class="form-control form-control-sm mt-2"
                   id="iataFilter" name="iata"
                   value="<?= htmlspecialchars($_GET['iata'] ?? '') ?>"
                   placeholder="Enter IATA code"
                   <?= empty($_GET['iata']) ? 'disabled' : '' ?>>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableICAO"
                    <?= !empty($_GET['icao']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-semibold" for="enableICAO">ICAO</label>
            </div>
            <input type="text" class="form-control form-control-sm mt-2"
                   id="icaoFilter" name="icao"
                   value="<?= htmlspecialchars($_GET['icao'] ?? '') ?>"
                   placeholder="Enter ICAO code"
                   <?= empty($_GET['icao']) ? 'disabled' : '' ?>>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableAirline"
                    <?= !empty($_GET['airline_name']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-semibold" for="enableAirline">Airline</label>
            </div>
            <input type="text" class="form-control form-control-sm mt-2"
                   id="airlineFilter" name="airline_name"
                   value="<?= htmlspecialchars($_GET['airline_name'] ?? '') ?>"
                   placeholder="Enter airline name"
                   <?= empty($_GET['airline_name']) ? 'disabled' : '' ?>>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableCallsign"
                    <?= !empty($_GET['callsign']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-semibold" for="enableCallsign">Callsign</label>
            </div>
            <input type="text" class="form-control form-control-sm mt-2"
                   id="callsignFilter" name="callsign"
                   value="<?= htmlspecialchars($_GET['callsign'] ?? '') ?>"
                   placeholder="Enter callsign"
                   <?= empty($_GET['callsign']) ? 'disabled' : '' ?>>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="enableCountry"
                    <?= !empty($_GET['region']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-semibold" for="enableCountry">Country/Region</label>
            </div>
            <input type="text" class="form-control form-control-sm mt-2"
                   id="countryFilter" name="region"
                   value="<?= htmlspecialchars($_GET['region'] ?? '') ?>"
                   placeholder="Enter country/region"
                   <?= empty($_GET['region']) ? 'disabled' : '' ?>>
        </div>
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
    const filters = [
        { checkbox: "enableIATA", input: "iataFilter" },
        { checkbox: "enableICAO", input: "icaoFilter" },
        { checkbox: "enableAirline", input: "airlineFilter" },
        { checkbox: "enableCallsign", input: "callsignFilter" },
        { checkbox: "enableCountry", input: "countryFilter" }
    ];

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
            e.preventDefault(); // stop default link reload
            filters.forEach(f => {
                const cb = document.getElementById(f.checkbox);
                const input = document.getElementById(f.input);
                if (cb && input) {
                    cb.checked = false;
                    input.disabled = true;
                    input.value = "";
                }
            });
            // redirect to base page (remove query params)
            window.location.href = "<?= strtok($_SERVER['REQUEST_URI'], '?') ?>";
        });
    }
});
</script>
