@foreach ($images->chunk(3) as $chunk)
    <div class="row image-row-container">
        @foreach ($chunk as $image)
            <div class="col-md-4 image-page-image-container text-center">
                <div class="pa-flex-center-container">
                    <img class="img-thumbnail image-preview"
                         src='{{ \App\Http\Controllers\ImageController::getImageAssetPath($image->subdirectory, $image->filename) }}'>
                </div>
                <div class="auto-margin-top">
                    <p class="image-filename">{{ $image->filename }}</p>
                    @if (str_contains(Request::url(), 'images'))
                        <form action="/images/{{ $image->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary btn-sm"
                               href="{{ \App\Http\Controllers\ImageController::getImageAssetPath($image->subdirectory, $image->filename) }}"
                               download>Download</a>
                            <input class="btn btn-sm btn-danger"
                                   type="submit"
                                   value="Delete"
                                   onclick="if (confirm('Are you sure you want to delete this image?')) { this.closest('form').submit(); } return false">
                        </form>
                    @else
                        @php
                            $filesystemDriver = config('filesystems.default');
                            $s3PublicUrl = config('filesystems.disks.s3.public_url');
                        @endphp
                        <a class="btn btn-sm btn-primary"
                           data-bs-dismiss="modal"
                           onclick='app.selectImage("{{ $image->id }}",
                           "{{ $image->filename }}",
                           "{{ $filesystemDriver }}",
                           "{{ $s3PublicUrl }}")'>Select</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach
