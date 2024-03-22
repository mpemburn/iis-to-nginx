<div>
    <form wire:submit.prevent="save">
        @if($showConvertControls)
            <label for="source">Source file: <span class="required">*</span>
                <br>
                <input type="file" name="source" wire:model="sourceFile">
                @error('sourceFile') <span class="error">{{ $message }}</span> @enderror
            </label>

            <label for="destination">Output filename: <span class="required">*</span>
                <br>
                <input type="text" name="destination" wire:model="destinationFile" required>
            </label>

            <button class="control-btn" type="submit" {{ $sourceFile ? '' : 'disabled' }}>Convert</button>
        @endif
        @if($showDownloadControls)
            <h5>"{{ $destinationFile }}" is ready:</h5>
            <button class="control-btn" type="button" wire:click="download">Download</button>
            <button class="control-btn" type="button" wire:click="clear">Clear</button>
        @endif
    </form>
</div>
