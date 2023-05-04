@php
    $postImages = array_values(File::allFiles(public_path('storage/images/posts')));
@endphp
@foreach ($postImages as $index => $image)
    @php $imageName = basename($image); @endphp
    @if ($index == 0)
        <div class="row image-row-container">
    @endif

    <div class="col-md-4 image-page-image-container text-center">
        <div class="flex-center-container">
            <img src='{{ \App\Http\Controllers\PostController::getImageAssetPath($imageName) }}'
                class="img-thumbnail image-preview">
        </div>
        <div class="auto-margin-top">
            @if (str_contains(Request::url(), 'images'))
                <form action="{{ route('delete-image') }}" method="post">
                    @csrf

                    <strong>{{ $imageName }}<br /></strong>
                    <input type="hidden" name="id" value="{{ $imageName }}">
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
        @elseif ($index == count($postImages) - 1 || $image == end($postImages))
        </div>
    @endif
@endforeach
