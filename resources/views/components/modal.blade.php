<div>
    @if($useButton ?? "")
    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">{{ $buttonText }}</button>
    @endif
    <div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body" id="body-{{ $modalId }}">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-{{ $modalId }}">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if($useForm ?? "")
<script>
    document.getElementById("submit-{{ $modalId }}").addEventListener('click', () => {
        let form = document.getElementById("body-{{ $modalId }}").children[0]
        form.submit()
    });
@endif
</script>