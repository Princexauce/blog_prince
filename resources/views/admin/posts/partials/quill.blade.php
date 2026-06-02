<input type="file" id="quillImageInput" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">

<div id="quillImageSizeToolbar" class="hidden absolute z-20 flex flex-wrap items-center gap-1 rounded-lg border border-gray-200 bg-white px-2 py-2 shadow-lg">
    <span class="text-xs font-semibold text-gray-500 px-1">Taille :</span>
    <button type="button" data-width="25%" class="quill-size-btn rounded px-2 py-1 text-xs font-medium text-gray-700 hover:bg-purple-100 hover:text-purple-700">25%</button>
    <button type="button" data-width="50%" class="quill-size-btn rounded px-2 py-1 text-xs font-medium text-gray-700 hover:bg-purple-100 hover:text-purple-700">50%</button>
    <button type="button" data-width="75%" class="quill-size-btn rounded px-2 py-1 text-xs font-medium text-gray-700 hover:bg-purple-100 hover:text-purple-700">75%</button>
    <button type="button" data-width="100%" class="quill-size-btn rounded px-2 py-1 text-xs font-medium text-gray-700 hover:bg-purple-100 hover:text-purple-700">100%</button>
</div>

<style>
    #editor {
        position: relative;
    }
    #editor .ql-editor img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        cursor: pointer;
    }
    #editor .ql-editor img.quill-image-selected {
        outline: 2px solid #a855f7;
        outline-offset: 2px;
    }
    .quill-size-btn.is-active {
        background-color: #ede9fe;
        color: #7c3aed;
    }
</style>

<script>
(function () {
    const uploadUrl = @json(route('admin.posts.upload-image'));
    const csrfToken = @json(csrf_token());
    const formId = @json($formId);
    const initialContent = @json($initialContent ?? null);
    const maxImageBytes = 10 * 1024 * 1024;
    const defaultImageWidth = '75%';

    const BaseImage = Quill.import('formats/image');

    class ResizableImage extends BaseImage {
        static create(value) {
            const src = typeof value === 'object' ? value.src : value;
            const node = super.create(src);
            const style = typeof value === 'object' && value.style
                ? value.style
                : 'width:' + defaultImageWidth + ';height:auto;';
            node.setAttribute('style', style);
            return node;
        }

        static value(domNode) {
            const src = domNode.getAttribute('src');
            const style = domNode.getAttribute('style');
            if (style) {
                return { src: src, style: style };
            }
            return src;
        }

        static formats(domNode) {
            const formats = {};
            if (domNode.hasAttribute('style')) {
                formats.style = domNode.getAttribute('style');
            }
            return formats;
        }

        format(name, value) {
            if (name === 'style') {
                if (value) {
                    this.domNode.setAttribute('style', value);
                } else {
                    this.domNode.removeAttribute('style');
                }
            } else {
                super.format(name, value);
            }
        }
    }

    Quill.register(ResizableImage, true);

    const quillImageInput = document.getElementById('quillImageInput');
    const sizeToolbar = document.getElementById('quillImageSizeToolbar');
    let selectedImage = null;

    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['link', 'image', 'video'],
                    ['clean'],
                ],
                handlers: {
                    image: function () {
                        quillImageInput.value = '';
                        quillImageInput.click();
                    },
                },
            },
        },
    });

    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    window.adminQuill = quill;

    function imageWidthFromStyle(img) {
        const match = (img.getAttribute('style') || '').match(/width:\s*(\d+%)/);
        return match ? match[1] : '100%';
    }

    function setImageWidth(img, width) {
        img.setAttribute('style', 'width:' + width + ';height:auto;');
        highlightActiveSizeButton(width);
    }

    function highlightActiveSizeButton(width) {
        sizeToolbar.querySelectorAll('.quill-size-btn').forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.width === width);
        });
    }

    function hideSizeToolbar() {
        sizeToolbar.classList.add('hidden');
        if (selectedImage) {
            selectedImage.classList.remove('quill-image-selected');
        }
        selectedImage = null;
    }

    function showSizeToolbar(img) {
        quill.root.querySelectorAll('img').forEach(function (image) {
            image.classList.remove('quill-image-selected');
        });
        selectedImage = img;
        img.classList.add('quill-image-selected');

        const editor = document.getElementById('editor');
        const imgRect = img.getBoundingClientRect();
        const editorRect = editor.getBoundingClientRect();

        sizeToolbar.style.top = (imgRect.bottom - editorRect.top + editor.scrollTop + 8) + 'px';
        sizeToolbar.style.left = Math.max(0, imgRect.left - editorRect.left) + 'px';
        sizeToolbar.classList.remove('hidden');

        highlightActiveSizeButton(imageWidthFromStyle(img));
    }

    quill.root.addEventListener('click', function (e) {
        if (e.target.tagName === 'IMG') {
            showSizeToolbar(e.target);
            return;
        }
        if (!sizeToolbar.contains(e.target)) {
            hideSizeToolbar();
        }
    });

    sizeToolbar.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-width]');
        if (!btn || !selectedImage) {
            return;
        }
        setImageWidth(selectedImage, btn.dataset.width);
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('editor').contains(e.target) && !sizeToolbar.contains(e.target)) {
            hideSizeToolbar();
        }
    });

    async function uploadImageToServer(file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', csrfToken);

        const response = await fetch(uploadUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        });

        const data = await response.json();

        if (!response.ok) {
            const validationError = data.errors?.file?.[0];
            throw new Error(data.error || validationError || data.message || 'Erreur lors du téléversement de l\'image.');
        }

        return data.location;
    }

    function insertImageAtCursor(url) {
        const range = quill.getSelection(true);
        const index = range ? range.index : quill.getLength();
        quill.insertEmbed(index, 'image', {
            src: url,
            style: 'width:' + defaultImageWidth + ';height:auto;',
        }, Quill.sources.USER);
        quill.setSelection(index + 1, Quill.sources.SILENT);

        const images = quill.root.querySelectorAll('img');
        const img = images[images.length - 1];
        if (img) {
            showSizeToolbar(img);
        }
    }

    quillImageInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Veuillez choisir une image (JPEG, PNG, GIF ou WebP).');
            return;
        }

        if (file.size > maxImageBytes) {
            alert('L\'image dépasse 10 Mo. Choisissez un fichier plus léger.');
            return;
        }

        try {
            const url = await uploadImageToServer(file);
            insertImageAtCursor(url);
        } catch (error) {
            alert(error.message);
        }
    });

    document.getElementById(formId).addEventListener('submit', function (e) {
        hideSizeToolbar();
        const content = quill.root.innerHTML;

        if (!content || content === '<p><br></p>') {
            e.preventDefault();
            alert('Veuillez écrire du contenu');
            return false;
        }

        document.getElementById('contenuInput').value = content;
    });
})();
</script>
