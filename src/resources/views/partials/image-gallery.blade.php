<div class="row image-row-container">
    @php
        $postImages = array_values(File::allFiles(public_path('storage/images/posts')));
    @endphp
    @foreach ($postImages as $index => $image)
        @php $imageName = basename($image); @endphp

        <div class="col-md-4 image-page-image-container text-center">
            <div class="flex-center-container">
                <img src='{{ \App\Http\Controllers\PostController::getImageAssetPath($imageName) }}'
                    class="img-thumbnail image-preview">
            </div>
            <div class="auto-margin-top">
                @if (str_contains(Request::url(), 'images'))
                    <form action="/images/{{ str_replace('.png', '', $imageName) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <strong>{{ $imageName }}<br /></strong>
                        <a class="btn btn-primary btn-sm"
                            href="{{ \App\Http\Controllers\PostController::getImageAssetPath($imageName) }}"
                            download>Download</a>
                        <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                    </form>
                @else
                    <a class="btn btn-sm btn-primary" data-bs-dismiss="modal"
                        onclick='app.selectImage("{{ $imageName }}")'>Select</a>
                @endif
            </div>
        </div>

        @if (($index + 1) % 3 == 0)
</div>
<div class="row image-row-container">
    @endif
    @endforeach
</div>
