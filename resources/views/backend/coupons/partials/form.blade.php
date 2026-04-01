<div class="row g-3">
    <div class="col-md-4">
        <label class="df-form-label">Code <span class="text-danger">*</span></label>
        <input type="text" name="code" class="df-form-control" value="{{ old('code', optional($coupon)->code) }}"
               placeholder="e.g. SUMMER25" required style="text-transform:uppercase;">
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Type <span class="text-danger">*</span></label>
        @php $selectedType = old('type', optional($coupon)->type ?? 'percent'); @endphp
        <select name="type" class="df-form-select" required>
            <option value="percent" {{ $selectedType === 'percent' ? 'selected' : '' }}>Percent (%)</option>
            <option value="fixed" {{ $selectedType === 'fixed' ? 'selected' : '' }}>Fixed (₹)</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Amount <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0.01" name="amount" class="df-form-control"
               value="{{ old('amount', optional($coupon)->amount) }}" placeholder="e.g. 10" required>
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Max Uses</label>
        <input type="number" min="1" name="max_uses" class="df-form-control"
               value="{{ old('max_uses', optional($coupon)->max_uses) }}" placeholder="Unlimited if empty">
        <p class="df-form-hint">Leave empty for unlimited usage.</p>
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Min Order Amount</label>
        <input type="number" step="0.01" min="0" name="min_order_amount" class="df-form-control"
               value="{{ old('min_order_amount', optional($coupon)->min_order_amount) }}" placeholder="Optional">
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Starts At</label>
        <input type="datetime-local" name="starts_at" class="df-form-control"
               value="{{ old('starts_at', optional(optional($coupon)->starts_at)->format('Y-m-d\TH:i')) }}">
    </div>

    <div class="col-md-4">
        <label class="df-form-label">Expires At</label>
        <input type="datetime-local" name="expires_at" class="df-form-control"
               value="{{ old('expires_at', optional(optional($coupon)->expires_at)->format('Y-m-d\TH:i')) }}">
    </div>

    @if($coupon)
        <div class="col-md-4">
            <label class="df-form-label">Used Count</label>
            <input type="number" class="df-form-control" value="{{ $coupon->used_count }}" readonly
                   style="opacity:0.7; cursor:not-allowed;">
        </div>
    @endif

    <div class="col-md-4 d-flex align-items-center">
        <div style="margin-top:28px;">
            <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', optional($coupon)->is_active ?? true) ? 'checked' : '' }}
                       style="width:18px; height:18px; accent-color:var(--df-primary);">
                <span class="df-form-label mb-0">Active</span>
            </label>
        </div>
    </div>
</div>
