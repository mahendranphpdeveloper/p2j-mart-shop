<div class="modal fade" id="addAttributeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  text-white">
                <h5 class="modal-title">Add New Attribute</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('attributes.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="fw-bold">Attribute Name</label>
                        <input type="text" name="attribute_name" class="form-control" required>
                    </div>

         
                    <div class="mb-3">
                        <label class="fw-bold">Display Order</label>
                        <input type="number" min="1" max="{{$attributeCount + 1}}" name="display_order" class="form-control" value="{{$attributeCount + 1}}" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.getElementById("add-text-option");
    const inputField = document.getElementById("new-text-option");
    const container = document.getElementById("text-options-container");
    const hiddenInput = document.getElementById("text-options-array");

    addButton.addEventListener("click", function () {
        const textValue = inputField.value.trim();

        if (!textValue) return;

        // Prevent duplicate values
        if ([...container.children].some(el => el.textContent.trim() === textValue)) return;

        // Create option element
        const span = document.createElement("span");
        span.classList.add("badge", "bg-secondary", "text-option");
        span.innerHTML = `${textValue} <button type="button" class="btn-close remove-option"></button>`;

        container.appendChild(span);
        inputField.value = "";
        updateTextArray();
    });

    // Remove option event listener
    container.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-option")) {
            event.target.parentElement.remove();
            updateTextArray();
        }
    });

    function updateTextArray() {
        const textOptions = [...container.children].map(el => el.textContent.trim());
        hiddenInput.value = JSON.stringify(textOptions);
    }
});
</script>
<style>
    .text-option {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
    }
    .remove-option {
        margin-left: 5px;
        background: transparent;
        border: none;
        cursor: pointer;
    }
</style>
