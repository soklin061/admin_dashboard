@props([
    'name',
    'value' => null,
    'placeholder' => 'Drag and drop your image here, or click to browse'
])

<div x-data="{
    isDragging: false,
    filePreview: @js($value),
    fileName: '',
    handleFile(event) {
        const file = event.target.files[0];
        if (file) {
            this.fileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.filePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}" 
    @dragover.prevent="isDragging = true" 
    @dragleave.prevent="isDragging = false"
    @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; handleFile({ target: $refs.fileInput })"
    class="w-full">
    
    <label class="relative flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-dashed rounded-lg cursor-pointer transition-colors duration-150"
        :class="isDragging ? 'border-indigo-500 bg-indigo-50/50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'">
        
        <!-- Hidden file input -->
        <input x-ref="fileInput" type="file" name="{{ $name }}" accept="image/*" class="hidden" @change="handleFile">

        <div class="p-6 flex flex-col items-center text-center">
            <!-- No file selected/no preview -->
            <template x-if="!filePreview">
                <div>
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 font-medium">{{ $placeholder }}</p>
                    <p class="mt-1 text-xs text-gray-400">PNG, JPG, GIF up to 5MB</p>
                </div>
            </template>

            <!-- File preview -->
            <template x-if="filePreview">
                <div class="space-y-3">
                    <img :src="filePreview" class="mx-auto max-h-32 object-contain rounded-md shadow-sm border border-gray-200">
                    <div class="text-xs text-gray-500">
                        <span x-text="fileName ? 'Selected: ' + fileName : 'Current Image'"></span>
                        <span class="block text-indigo-600 font-medium hover:underline mt-1">Change Image</span>
                    </div>
                </div>
            </template>
        </div>
    </label>
</div>
