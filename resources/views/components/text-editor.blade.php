@props([
    'name',
    'value' => '',
    'placeholder' => 'Write something...'
])

<div x-data="{
    value: @js($value),
    initQuill() {
        let checkQuill = setInterval(() => {
            if (window.Quill) {
                clearInterval(checkQuill);
                
                const quill = new Quill(this.$refs.editorContainer, {
                    theme: 'snow',
                    placeholder: '{{ $placeholder }}',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'header': [1, 2, 3, false] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });

                quill.root.innerHTML = this.value;

                quill.on('text-change', () => {
                    this.value = quill.root.innerHTML;
                });
            }
        }, 100);
    }
}" 
x-init="initQuill"
class="w-full">
    @once
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js" defer></script>
    @endonce

    <!-- Hidden field to submit data -->
    <input type="hidden" name="{{ $name }}" :value="value">

    <!-- Quill Editor Container -->
    <div class="border border-gray-300 rounded-md overflow-hidden bg-white">
        <div x-ref="editorContainer" class="min-h-[150px]"></div>
    </div>
</div>
