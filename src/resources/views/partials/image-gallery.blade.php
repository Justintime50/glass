@foreach ($images->chunk(3) as $chunk)
    <div class="row image-row-container">
        @foreach ($chunk as $image)
            <div class="col-md-4 image-page-image-container text-center">
                <div class="pa-flex-center-container">
                    <img src='{{ \App\Http\Controllers\ImageController::getImageAssetPath($image->subdirectory, $image->filename) }}'
                        class="img-thumbnail image-preview">
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
                            <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                        </form>
                    @else
                        <a class="btn btn-sm btn-primary" data-bs-dismiss="modal"
                            onclick='app.selectImage("{{ $image->id }}", "{{ $image->filename }}")'>Select</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach
