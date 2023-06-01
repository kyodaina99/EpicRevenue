<div class="row">
    @foreach ($files as $file)
    <div class="col-md-6 col-lg-3">
        <div class="card p-4 file-manager-item" 
            onclick="checkFileItem(this)"
            id="item{{ $file->id }}"
            data-id="{{ $file->id }}"
            data-file-path="{{$file->getImageOptimizedFullName(400)}}"
            data-origin-path="{{$file->getImageOriginFullPath()}}"
        >
            <div class="check-option d-none">✔</div>
            <span class="file-created-at mb-3">{{ $file->created_at->format('M d, Y, h:i:s A') }}</span>
            <img src="{{ $file->getImageOptimizedFullName() }}" class="card-img-top img-thumbnail" alt="{{ $file->file_name }}">
            <div class="card-body">
                <h5 class="card-title text-center">{{ $file->getOriginalFileFullName() }}</h5>
                <span class="file-size">{{ number_format($file->file_size/1024/1024, 2, ".", ",") }} MB</span>
            </div>
        </div>

    </div>
    @endforeach
    {{ $files->links('vendor.pagination.default') }}
</div>

<script>
    $('ul.pagination').find('li').each(function() {
        var link = $(this).find('a');

        link.on('click', function(e){
            e.preventDefault();
            var url = $(link).attr('href');
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + `search=${$('#search_word').val()}`;

            $("#files_container").empty();
            $('.files-placeholder').show();
            $.get(finalURL, function(data) {
                $("#files_container").html(data);

                // select the items on other page
                selected.map(function(item) {
                    $(`#item${item}`).addClass('file-manager-item-checked');
                })

                $('.files-placeholder').hide();
            });
        })
    });
</script>