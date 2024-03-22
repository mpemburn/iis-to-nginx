<div>
    <form wire:submit.prevent="save">
        @if($showConvertControls)
            <input type="file" wire:model="configFile">
            @error('configFile') <span class="error">{{ $message }}</span> @enderror

            <label for="destination">Output filename:
                <input type="text" name="destination" wire:model="destinationFile">
            </label>

            <button type="submit">Convert</button>
        @endif
        @if($showDownloadControls)
            <h5>"{{ $destinationFile }}" is ready:</h5>
            <button type="button" wire:click="download">Download</button>
            <button type="button" wire:click="clear">Clear</button>
        @endif
    </form>
</div>
