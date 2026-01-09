<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead class="thead-default">
            <tr>
                <th style="">Preview</th>
                <th style="">Name</th>
                <th style="width:10%">File Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
              if (isset($media['files'])) {
                $k = 0;
                foreach ($media['files'] as $file) {
                    $k++;
                    if (str_contains($file['file_type'], 'image') || (str_contains($file['file_type'], 'video'))  && ($choose_type == 'news_image')) {
            ?>
            <tr>
                <td>
                    <a class="mfp-image" data-group="3" onclick="get_value(this.id);" id="<?php echo $file['file_name']; ?>"
                        title="<?php echo $file['file_name']; ?>">
                        @if (str_contains($file['file_type'], 'image'))
                        <img src="{{ $file['media_url'] }}" alt="<?php echo $file['file_name']; ?>" style="<?php echo 'width:200px;height:120px'; ?>" />
                        @elseif(str_contains($file['file_type'], 'video'))
                        <video width="200px" controls>
                            <source src="{{ asset($file['path']) }}" type="{{ $file['file_type'] }}">
                            Your browser does not support HTML video.
                        </video>
                    @endif
                    </a>
                </td>
                <td>
                    <span>
                        <a class="mfp-image" data-group="4" onclick="get_value(this.id);" id="{{ $file['file_name'] }}"
                            href="" title="{{ $file['file_name'] }}">
                            {{ $file['file_name'] }}</a>
                    </span>
                </td>

                <td>
                    <span>
                        {{  $file['file_type'] }}
                    </span>
                    {{-- <a class="btn btn-sm btn-danger btn-delete" target="_top" href="#" data-media="file"
                        title="Delete" data-media_uid="{{ $file['media_uid'] }}"><span class="fa fa-times"></span></a> --}}
                </td>
            </tr>
            <?php }
                }
            }
            ?>
        </tbody>
    </table>
</div>
