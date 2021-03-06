@stack($name . '_input_start')

    <div
        class="form-group {{ $col }}{{ isset($attributes['required']) ? ' required' : '' }}{{ isset($attributes['readonly']) ? ' readonly' : '' }}{{ isset($attributes['disabled']) ? ' disabled' : '' }}"
        :class="[{'has-error': errors.{{ $name }}}]">
        @if (!empty($text))
            {!! Form::label($name, $text, ['class' => 'form-control-label'])!!}
        @endif

        <div class="input-group input-group-merge">
            <akaunting-dropzone-file-upload
                text-drop-file="{{ trans('general.form.drop_file') }}"
                text-choose-file="{{ trans('general.form.choose_file') }}"

                @if (!empty($attributes['dropzone-class']))
                class="{{ $attributes['dropzone-class'] }}"
                @endif

                @if (!empty($attributes['options']))
                :options={{ json_encode($attributes['options']) }}
                @endif

                @if (!empty($attributes['preview']))
                :preview={{ json_encode($attributes['preview']) }}
                @endif

                @if (!empty($attributes['multiple']))
                multiple
                @endif

                @if (!empty($attributes['previewClasses']))
                preview-classes="{{ $attributes['previewClasses'] }}"
                @endif

                @if (!empty($attributes['url']))
                url="{{ $attributes['url'] }}"
                @endif

                @if (!empty($value))
                    @php
                        $attachments = [];
                    @endphp

                    @if (is_array($value))
                        @foreach($value as $attachment)
                            @php
                                $attachments[] = [
                                    'name' => $attachment->filename . '.' . $attachment->extension, 
                                    'path' => route('uploads.get', $attachment->id), 
                                    'downloadPath' => route('uploads.download', $attachment->id)
                                ];
                            @endphp
                        @endforeach
                    @elseif ($value instanceof \Plank\Mediable\Media)
                        @php
                            $attachments[] = [
                                'name' => $value->filename . '.' . $value->extension,
                                'path' => route('uploads.get', $value->id)
                            ];
                        @endphp
                    @else
                        @php
                            $attachment = \Plank\Mediable\Media::find($value);

                            $attachments[] = [
                                'name' => $attachment->filename . '.' . $attachment->extension,
                                'path' => route('uploads.get', $attachment->id)
                            ];
                        @endphp
                    @endif
                
                :attachments="{{ json_encode($attachments) }}"
                @endif

                v-model="{{ !empty($attributes['v-model']) ? $attributes['v-model'] : (!empty($attributes['data-field']) ? 'form.' . $attributes['data-field'] . '.'. $name : 'form.' . $name) }}"
            ></akaunting-dropzone-file-upload>
        </div>

        <div class="invalid-feedback d-block"
            v-if="{{ isset($attributes['v-error']) ? $attributes['v-error'] : 'form.errors.has("' . $name . '")' }}"
            v-html="{{ isset($attributes['v-error-message']) ? $attributes['v-error-message'] : 'form.errors.get("' . $name . '")' }}">
        </div>
    </div>

@stack($name . '_input_end')
