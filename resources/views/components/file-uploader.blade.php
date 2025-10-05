@props([
    'name' => '',
    'accept' => '*',
    'SID' => null,
])

<div class="file-uploader">
    <!-- main file input -->
    <input type="file" name="{{ $name }}" accept="{{ $accept }}" class="form-control file-input mb-4">

    <!-- button (only if SID is provided) -->
    @if($SID)
        <a href="{{ route('storage.download', $SID) }}" class="btn btn-outline-primary mb-3 file-btn" target="_blank">{{ lt('Show file') }}</a>
    @endif

    <!-- preview area (hidden initially) -->
    <div class="preview" hidden>
        <!-- image -->
        <img class="preview-img img-fluid rounded mb-2" alt="Image preview" hidden style="max-width: 400px; max-height: 200px;">

        <!-- audio -->
        <audio controls class="preview-audio mb-2" hidden style="max-width: 400px; max-height: 200px; width: 100%;"></audio>

        <!-- video -->
        <video controls class="preview-video rounded mb-2" hidden style="max-width: 400px; max-height: 200px; width: 100%;"></video>

        <!-- text/pdf -->
        <iframe class="preview-iframe mb-2" hidden style="max-width: 400px; max-height: 200px; width: 100%; height: 200px; border:1px solid #dee2e6; border-radius:.25rem;"></iframe>

        <!-- fallback: filename -->
        <p class="preview-filename text-muted mb-2" hidden></p>
    </div>
</div>

<script>
    (function(){
        function ensureJQuery(callback){
            if (typeof jQuery !== 'undefined') return callback(jQuery);
            var s = document.createElement('script');
            s.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
            s.onload = function(){ callback(window.jQuery); };
            document.head.appendChild(s);
        }

        ensureJQuery(function($){
            $('.file-uploader').each(function(){
                var $wrap = $(this);
                var $input = $wrap.find('.file-input');
                var $preview = $wrap.find('.preview');
                var $btn = $wrap.find('.file-btn'); // button (if exists)
                var $img = $wrap.find('.preview-img');
                var $audio = $wrap.find('.preview-audio');
                var $video = $wrap.find('.preview-video');
                var $iframe = $wrap.find('.preview-iframe');
                var $fname = $wrap.find('.preview-filename');

                function hideAllPreviews() {
                    $preview.attr('hidden', true);
                    $img.attr('hidden', true).attr('src','');
                    $audio.attr('hidden', true).attr('src','');
                    $video.attr('hidden', true).attr('src','');
                    $iframe.attr('hidden', true).attr('src','');
                    $fname.attr('hidden', true).text('');
                }

                // Initially hide all previews
                hideAllPreviews();

                $input.on('change', function(){
                    hideAllPreviews();
                    if ($btn.length) $btn.attr('hidden', true); // hide button if exists

                    var file = this.files && this.files[0];
                    if (!file) return;

                    var type = file.type;
                    var url = URL.createObjectURL(file);

                    // Show the preview container
                    $preview.removeAttr('hidden');

                    // Show only the correct type
                    if (type.startsWith('image/')) {
                        $img.attr('src', url).removeAttr('hidden');
                    }
                    else if (type.startsWith('audio/')) {
                        $audio.attr('src', url).removeAttr('hidden');
                    }
                    else if (type.startsWith('video/')) {
                        $video.attr('src', url).removeAttr('hidden');
                    }
                    else if (type.startsWith('text/') || type === 'application/pdf') {
                        $iframe.attr('src', url).removeAttr('hidden');
                    }
                    else {
                        $fname.text("Selected file: " + file.name).removeAttr('hidden');
                    }
                });
            });
        });
    })();
</script>
