{{--
    Shared traffic form fields — used by both Add and Edit offcanvases.
    When $editing is true, fields are pre-filled via JS (openEdit()).
--}}
<div class="mb-3">
    <label class="form-label fw-semibold">Tarif nomi <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="name" required
           placeholder="Masalan: Start, Pro, Business...">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Tavsif <span class="text-danger">*</span></label>
    <textarea class="form-control" name="annotation" rows="2" required
              placeholder="Qisqa tavsif..."></textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Narxi (so'm) <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="number" class="form-control" name="price" min="0" required placeholder="0">
        <span class="input-group-text">so'm</span>
    </div>
</div>

<div class="row g-2 mb-3">
    <div class="col-6">
        <label class="form-label fw-semibold">Mijozlar soni</label>
        <input type="number" class="form-control" name="clients_count" min="0" value="0" required>
    </div>
    <div class="col-6">
        <label class="form-label fw-semibold">SMS / Reklama</label>
        <input type="number" class="form-control" name="sms_count" min="0" value="0" required>
    </div>
    <div class="col-6">
        <label class="form-label fw-semibold">Tovarlar soni</label>
        <input type="number" class="form-control" name="products_count" min="0" value="0" required>
    </div>
    <div class="col-6">
        <label class="form-label fw-semibold">Xodimlar soni</label>
        <input type="number" class="form-control" name="users_count" min="0" value="0" required>
    </div>
</div>

<div class="row g-2 mb-0">
    <div class="col-6">
        <label class="form-label fw-semibold">Turi</label>
        <select class="form-select" name="status" required>
            <option value="0">Asosiy</option>
            <option value="1">Qo'shimcha</option>
        </select>
    </div>
    <div class="col-6">
        <label class="form-label fw-semibold">Davri</label>
        <select class="form-select" name="type_traffic" required>
            <option value="month">Oylik</option>
            <option value="year">Yillik</option>
        </select>
    </div>
</div>
