@php
$id = 'id' . uniqid();
$originalName = $id  . 'orginal';
if (!isset($minWidth)) {
    $minWidth = 0;
}
if (!isset($minHeight)) {
    $minHeight = 0;
}
if (!isset($currentPicturePath)) {
    $currentPicturePath = null;
}
@endphp

<div class="form-group" id="{{$id}}">
    <label for="imageInput">{{ $inputLabel }}</label>

    @if($currentPicturePath)
        <div class="mb-3">
            <img src="{{ Storage::url($currentPicturePath) }}" alt="{{$inputLabel}}"
                 class="img-fluid img-thumbnail"
                 style="max-height: 100px;">
        </div>
    @endif

    <div class="input-group">
        <div class="custom-file">
            <input type="file" name="{{$name}}" class="croppedImage" style="display: none">
            <input type="file" class="custom-file-input originalImage"  accept="image/*"
                   name="{{$originalName}}">
            <label class="custom-file-label"
                   for="imageInput">{{ $chooseFileLabel }}</label>
        </div>
        <img class="preview" style="max-width: 100%; display: none;"/>
    </div>
</div>

@push('js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const imageInput = document.querySelector('#{{$id}} .originalImage');
            const hiddenInput = document.querySelector('#{{$id}} .croppedImage');
            const preview = document.querySelector('#{{$id}} .preview');
            const form = imageInput.closest('form');
            let cropper;

            imageInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {

                        preview.src = e.target.result;
                        preview.onload = function () {
                            if ( ({{$minWidth}} > 0 && preview.naturalWidth < {{ $minWidth }}) || ({{$minHeight}} > 0 && preview.naturalHeight < {{ $minHeight }})) {
                                toastr.warning('Изображение должно быть не менее {{$minWidth}}x{{$minHeight}}пикселей.')
                            }
                        }

                        preview.style.display = 'block';

                        if (cropper) {
                            cropper.destroy();
                        }

                        cropper = new Cropper(preview, {
                            aspectRatio: {{$finalWidth/$finalHeight}},
                            viewMode: 1,
                            autoCropArea: 0.9,
                        });

                    };
                    reader.readAsDataURL(file);
                }
            });

            form.addEventListener('submit',(event) => {
                event.preventDefault();
                if (cropper) {
                    cropper.getCroppedCanvas({
                        width: {{$finalWidth}},
                        height: {{$finalHeight}},
                    }).toBlob((blob) => {
                        imageInput.value = "";
                        const newFile = new File([blob], "cropped-image.jpg", { type: "image/jpeg" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        hiddenInput.files = dataTransfer.files;
                        event.target.submit();
                    }, 'image/jpeg');
                }
                else {
                    event.target.submit();
                }
            });
        });

    </script>

@endpush
