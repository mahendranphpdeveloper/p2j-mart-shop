<div class="modal fade" id="editAttributeModal{{ $attribute->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  text-white">
                <h5 class="modal-title">Edit Attribute</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="fw-bold">Attribute Name</label>
                        <input type="text" name="attribute_name" class="form-control" value="{{ $attribute->attribute_name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Options</label>

                        @if(strtolower($attribute->attribute_name) === 'colors')
                        <!-- 🎨 Color Picker Section -->
                        <div class="color-picker-container">
                            <input type="color" id="color-picker-{{ $attribute->id }}" class="form-control d-none">
                            <button type="button" class="btn btn-success btn-sm mt-2 add-color" data-attribute-id="{{ $attribute->id }}">
                                ➕ Add Color
                            </button>

                            <!-- Selected Colors Preview -->
                            <div id="color-boxes-container{{ $attribute->id }}" class="d-flex flex-wrap gap-2 mt-3">
                                @foreach(json_decode($attribute->options, true) ?? [] as $color)
                                <div class="color-box" style="background-color: {{ $color }};" data-color="{{ $color }}">
                                    <button type="button" class="remove-color">&times;</button>
                                </div>
                                @endforeach
                            </div>

                            <!-- Hidden Input for Colors Array -->
                            <input type="hidden" name="colors" id="colors-array-{{ $attribute->id }}" value="{{ $attribute->options }}">
                        </div>
                        @else
                        <!-- 🏷️ Text Options -->
                        <div class="text-options-container">
                            <div id="text-options-container{{ $attribute->id }}" class="d-flex flex-wrap gap-2">
                                @foreach(json_decode($attribute->options, true) ?? [] as $option)
                                <span class="badge bg-secondary text-option">
                                    {{ $option }}
                                    <button type="button" class="btn-close remove-option">&times;</button>
                                </span>
                                @endforeach
                            </div>
                            <div class="d-flex mt-2">
                                <input type="text" class="form-control new-text-option" data-attribute-id="{{ $attribute->id }}" placeholder="Enter option">
                                <button type="button" class="btn btn-success ms-2 add-text-option" data-attribute-id="{{ $attribute->id }}">Add</button>
                            </div>
                        </div>
                        <input type="hidden" name="text_options" id="text-options-array-{{ $attribute->id }}" value="{{ $attribute->options }}">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Display Order</label>
                        <input type="number" name="display_order" min="1" max="{{$attributeCount + 1}}" class="form-control" value="{{ $attribute->display_order }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $attribute->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $attribute->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 🎨 Handle Color Addition
        document.querySelectorAll(".add-color").forEach(button => {
            button.addEventListener("click", function() {
                const attributeId = this.getAttribute("data-attribute-id");
                const colorPicker = document.getElementById(`color-picker-${attributeId}`);
                colorPicker.click();

                // Ensure the event listener only runs once per click
                colorPicker.addEventListener("change", function handleColorPick() {
                    const selectedColor = colorPicker.value;
                    addColorToContainer(attributeId, selectedColor);
                    colorPicker.removeEventListener("change", handleColorPick);
                }, {
                    once: true
                });
            });
        });

        function addColorToContainer(attributeId, color) {
            const container = document.querySelector(`#color-boxes-container${attributeId}`);
            const colorsArrayInput = document.getElementById(`colors-array-${attributeId}`);

            if ([...container.children].some(box => box.getAttribute("data-color") === color)) return;


            const colorBox = document.createElement("div");
            colorBox.classList.add("color-box");
            colorBox.style.backgroundColor = color;
            colorBox.setAttribute("data-color", color);


            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("remove-color");
            removeButton.innerHTML = "&times;";
            removeButton.addEventListener("click", function() {
                colorBox.remove();
                updateColorArray(attributeId);
            });
            colorBox.appendChild(removeButton);
            container.appendChild(colorBox);
            updateColorArray(attributeId);
        }

        function updateColorArray(attributeId) {
            const container = document.querySelector(`#color-boxes-container${attributeId}`);
            const colorsArrayInput = document.getElementById(`colors-array-${attributeId}`);
            const colors = [...container.children].map(box => box.getAttribute("data-color"));
            colorsArrayInput.value = JSON.stringify(colors);
        }
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("add-text-option")) {
                const attributeId = event.target.getAttribute("data-attribute-id");
                const inputField = document.querySelector(`.new-text-option[data-attribute-id="${attributeId}"]`);
                const textValue = inputField.value.trim();
                if (!textValue) return;
                const container = document.getElementById(`text-options-container${attributeId}`);
                const hiddenInput = document.getElementById(`text-options-array-${attributeId}`);
                // Prevent duplicates
                if ([...container.children].some(el => el.textContent.trim() === textValue)) return;
                // Create new text option element
                const span = document.createElement("span");
                span.classList.add("badge", "bg-secondary", "text-option");
                span.innerHTML = `
                ${textValue}
                <button type="button" class="btn-close remove-option" aria-label="Remove"></button>
            `;
                container.appendChild(span);
                inputField.value = "";
                updateTextArray(attributeId);
            }
            if (event.target.classList.contains("remove-option")) {
                const attributeId = event.target.closest(".text-options-container").querySelector(".new-text-option").getAttribute("data-attribute-id");
                event.target.parentElement.remove();
                updateTextArray(attributeId);
            }
        });

        function updateTextArray(attributeId) {
            const container = document.getElementById(`text-options-container${attributeId}`);
            const hiddenInput = document.getElementById(`text-options-array-${attributeId}`);
            // Extract only text (exclude the remove button text)
            const textOptions = [...container.children].map(el => el.childNodes[0].textContent.trim());
            hiddenInput.value = JSON.stringify(textOptions);
        }


    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add event listener to remove color buttons
        document.querySelectorAll(".color-box .remove-color").forEach(button => {
            button.addEventListener("click", function () {
                let colorBox = this.parentElement;
                let colorValue = colorBox.getAttribute("data-color");
                let attributeId = colorBox.parentElement.getAttribute("id").replace("color-boxes-container", "");
                let hiddenInput = document.getElementById("colors-array-" + attributeId);
                // Remove color from the hidden input value
                let colors = JSON.parse(hiddenInput.value || "[]");
                colors = colors.filter(color => color !== colorValue); // Remove the selected color
                hiddenInput.value = JSON.stringify(colors); // Update the hidden input

                // Remove the color box from the UI
                colorBox.remove();
            });
        });
    });
</script>
<style>
    .color-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 4px;
        border: 2px solid #ddd;
        cursor: pointer;
        margin: 2px;
    }

    .color-box .remove-color {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff0000;
        color: white;
        border: none;
        font-size: 12px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
</style>