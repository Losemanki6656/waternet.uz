{{-- Driver geographic coverage: Sity → Area assignment.
     Expects $sities (org sities with areas) and $assignedAreas (array of area ids). --}}
<div class="card rounded-3">
    <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">
            <i class="fas fa-map-marked-alt text-info me-2"></i>{{ __('messages.driver_areas') ?? 'Hududlar (Region → Area)' }}
        </h6>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-soft-primary" id="checkAllAreas">
                <i class="fas fa-check-double me-1"></i>{{ __('messages.select_all') ?? 'Hammasi' }}
            </button>
            <button type="button" class="btn btn-sm btn-soft-danger" id="uncheckAllAreas">
                <i class="fas fa-times me-1"></i>{{ __('messages.deselect_all') ?? 'Tozalash' }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            {{ __('messages.driver_areas_hint') ?? 'Haydovchi faqat tanlangan hududlardagi buyurtmalarni ko‘radi.' }}
        </p>

        @forelse ($sities as $sity)
            <div class="mb-3 area-sity-block">
                <div class="d-flex align-items-center mb-2">
                    <strong class="me-2">{{ $sity->name }}</strong>
                    <button type="button" class="btn btn-sm btn-link p-0 sity-toggle text-decoration-none">
                        {{ __('messages.select_all') ?? 'Hammasi' }}
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @forelse ($sity->areas as $area)
                        <label class="area-chip mb-0" for="area_{{ $area->id }}">
                            <input type="checkbox" class="area-checkbox" name="areas[]" value="{{ $area->id }}"
                                   id="area_{{ $area->id }}" @if(in_array($area->id, $assignedAreas)) checked @endif>
                            <span>{{ $area->name }}</span>
                        </label>
                    @empty
                        <span class="text-muted small">—</span>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-muted">{{ __('messages.no_regions') ?? 'Hududlar topilmadi' }}</div>
        @endforelse
    </div>
</div>

<style>
    .area-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border: 1px solid #e3e6ef;
        border-radius: 10px;
        cursor: pointer;
        font-size: 13px;
        user-select: none;
        transition: all .12s ease;
    }
    .area-chip:has(.area-checkbox:checked) {
        background: rgba(80, 165, 241, .12);
        border-color: #50a5f1;
        color: #2b6cb0;
        font-weight: 500;
    }
    .area-chip .area-checkbox {
        accent-color: #50a5f1;
    }
</style>

<script>
    (function () {
        var checkAll = document.getElementById('checkAllAreas');
        var uncheckAll = document.getElementById('uncheckAllAreas');

        function allBoxes() {
            return document.querySelectorAll('.area-checkbox');
        }

        if (checkAll) checkAll.addEventListener('click', function () {
            allBoxes().forEach(function (c) { c.checked = true; });
        });
        if (uncheckAll) uncheckAll.addEventListener('click', function () {
            allBoxes().forEach(function (c) { c.checked = false; });
        });

        document.querySelectorAll('.sity-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var block = btn.closest('.area-sity-block');
                var boxes = block.querySelectorAll('.area-checkbox');
                var allOn = Array.prototype.every.call(boxes, function (b) { return b.checked; });
                boxes.forEach(function (b) { b.checked = !allOn; });
            });
        });
    })();
</script>
